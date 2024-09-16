<?php

namespace App\Listeners;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Uuid;
use App\Models\Order;
use App\Events\PaymentDataReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SyncPaymentData implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PaymentDataReceived $event): void
    {
        try {
           // Extract the movie data from the event
            $data = json_decode($event->data);

            $user = User::where('id', $data->user_id)->first();
            if ($user->member_activate_in) {
                $user->update([
                    'renewal_date' => Carbon::now(),
                    'member_over_in' => Carbon::now()->addYear(),
                ]);
            } else {
                $user->update([
                    'member_activate_in' => Carbon::now(),
                    'member_over_in' => Carbon::now()->addYear(),
                    'status' => $data->status,
                    'registrant_tag' => "MEMBER"
                ]);
            }

            $order = Order::where('user_id', $data->user_id)
            ->update([
                'status' => $data->status
            ]);

            $uuid = $this->generateUniqueUuid($data->user_id);
            $url = url('/dashboard/presence/update?uuid=' . $uuid);
            $qrCode = QrCode::format('png')->size(150)->generate($url);
            $filename = 'qrcodes/' . $uuid . '.png';
            Storage::put('public/' . $filename, $qrCode);

            echo "Updated User: ", print_r($user, true);

            Log::info('User data synchronized: ' . $data->user_id);
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error in handle method: ' . $e->getMessage());
        }
    }

    function generateUniqueUuid(string $id)
    {
        do {
            // Generate a 10-digit UUID
            $uuid = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
        } while (Uuid::where('uuid', $uuid)->exists());

        // Save the UUID to the database
        Uuid::create([
            'uuid' => $uuid,
            'user_id' => $id,
            'valid_on' => Carbon::now() // 8 Mei 2025
        ]);

        return $uuid;
    }
}
