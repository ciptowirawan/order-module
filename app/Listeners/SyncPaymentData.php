<?php

namespace App\Listeners;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Uuid;
use App\Models\Order;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
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
            // Extract the data from the event
            $data = json_decode($event->data);

            $user = User::where('id', $data->user_id)->first();

            $paymentDate = Carbon::parse($data->payment_date);

            // Determine the membership end date based on payment month
            $membershipEndDate = $paymentDate->copy();
            if ($paymentDate->month <= 6) {
                // Jan-June payment: End in June same year
                $membershipEndDate->month(6)->endOfMonth();
            } else {
                // July-Dec payment: End in June next year
                $membershipEndDate->addYear()->month(6)->endOfMonth();
            }

            if (!$user->member_activate_in) {
                // New registration - first time member
                $user->update([
                    'member_activate_in' => $paymentDate,
                    'member_over_in' => $membershipEndDate,
                    'status' => $data->status,
                    'registrant_tag' => "MEMBER"
                ]);

                $uuid = $this->generateUniqueUuid($data->user_id);
                $url = url('/dashboard/presence/update?uuid=' . $uuid);
                $qrCode = QrCode::format('png')->size(150)->generate($url);
                $filename = 'qrcodes/' . $uuid . '.png';
                $qr = Storage::put('public/' . $filename, $qrCode);

                Log::info('QR Code data synchronized: ' . $qr);
            } else {
                // This is a renewal - they already have an activation date
                $currentOverIn = Carbon::parse($user->member_over_in);       
                
                // If current membership is expired, calculate from payment date
                if ($currentOverIn->isPast()) {
                    $newOverIn = $paymentDate->copy();
                    if ($paymentDate->format('n') <= 6) {
                        $newOverIn->month(6)->endOfMonth();
                    } else {
                        $newOverIn->addYear()->month(6)->endOfMonth();
                    }
                } else {
                    // If membership is still active, add one year to current end date
                    $newOverIn = $currentOverIn->copy()->addYear();
                }
                
                $user->update([
                    'renewal_date' => $paymentDate,
                    'member_over_in' => $newOverIn,
                ]);
            }

            // Update existing order status
            Order::where('user_id', $data->user_id)
                ->where('status', 'PENDING')  // Only update pending orders
                ->update(['status' => $data->status]);

            // Generate next billing after successful update
            $this->generateNextBilling($user, $data->amount);

            Log::info('User data synchronized: ' . $data->user_id);
        } catch (Exception $e) {
            Log::error('Error in handle method: ' . $e->getMessage());
            throw $e; // Re-throw the exception to ensure proper error handling
        }
    }

    private function generateNextBilling(User $user, float $amount): void
    {
        try {
            $membershipEnd = Carbon::parse($user->member_over_in);
            
            // Create new order for next period
            $order = Order::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'status' => 'PENDING',
                'due_date' => $membershipEnd->format('Y-m-d H:i:s')  // Format as string explicitly
            ]);

            $registrantData = $order->toArray();
            $registrantData['full_name'] = $user->full_name;
            $registrantData['account'] = $user->virtual_account;

            $message = new Message(
                topicName: 'registrant-created',
                headers: ['Content-Type' => 'application/json'],
                body: $registrantData,
                key: 'registrant-created'  
            );
        
            $producer = Kafka::publishOn('registrant-created')->withMessage($message);
            $producer->send();

            Log::info('Generated next billing for user: ' . $user->id);
        } catch (Exception $e) {
            Log::error('Error generating next billing: ' . $e->getMessage());
            throw $e; // Re-throw the exception to ensure proper error handling
        }
    }

    private function generateUniqueUuid(string $id): string
    {
        do {
            // Generate a 10-digit UUID
            $uuid = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
        } while (Uuid::where('uuid', $uuid)->exists());

        // Save the UUID to the database
        Uuid::create([
            'uuid' => $uuid,
            'user_id' => $id,
            'valid_on' => Carbon::now()->format('Y-m-d H:i:s')  // Format as string explicitly
        ]);

        return $uuid;
    }
}
