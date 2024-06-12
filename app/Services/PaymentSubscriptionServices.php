<?php

namespace App\Services;

use Interop\Queue\Context;
use Interop\Queue\Message;
use Enqueue\Consumption\QueueConsumer;
use Enqueue\SimpleClient\SimpleClient;

class PaymentSubscriptionService
{
    protected $client;
    protected $consumer;

    public function __construct()
    {
        $this->client = new SimpleClient(config('enqueue.default'));
        $this->consumer = $this->client->getQueueConsumer();
    }

    public function consume()
    {
        $this->consumer->bind('payment-success', function (Message $message, Context $context) {
            $event = json_decode($message->getBody(), true);
            // Process the event and create payment credentials
            if (isset($event['user_id'], $event['status'])) {
                $this->updateRegisterStatus($event['user_id'], $event['status']);
                echo "Received event: ", print_r($event, true);
            } else {
                // Handle the case where the necessary data is missing
                echo "Invalid event data: ", print_r($event, true);
            }
        });

        $this->consumer->consume();
    }

    private function updateRegisterStatus($user_id, $status)
    {
        
        $user = User::where('id', $user_id)
        ->update([
            'status' => $status
        ]);

        echo "Updated Payment: ", print_r($user, true);
    }
}
