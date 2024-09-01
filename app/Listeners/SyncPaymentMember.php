<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Events\PaymentMemberReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncPaymentMember implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PaymentMemberReceived $event): void
    {
        try {
           // Extract the movie data from the event
            $data = json_decode($event->data);

            $user = User::where('id', $data->user_id)
            ->update([
                'member_activate_in' => Carbon::now(),
                'member_over_in' => Carbon::now()->addYear(),
                'status' => $data->status,
                'registrant-tag' => "MEMBER"
            ]);

            echo "Updated User: ", print_r($user, true);

            Log::info('User data synchronized: ' . $data->user_id);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error in handle method: ' . $e->getMessage());
        }
    }
}
