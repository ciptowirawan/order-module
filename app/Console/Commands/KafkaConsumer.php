<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use App\Events\PaymentDataReceived;
use App\Events\PaymentMemberReceived;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaConsumer extends Command
{
    protected $signature = 'kafka:consume';
    protected $description = 'Consume messages from Kafka topics';

    public function handle()
    {
        // $consumerPaymentRegistrant = Kafka::createConsumer(['payment-success'])
        //     ->withHandler(function (KafkaConsumerMessage $message) {
        //         event(new PaymentDataReceived(json_encode($message->getBody())));
        //         $this->info('Received message: ' . json_encode($message->getBody()));
        //     })->build();

        // $consumerPaymentMember = Kafka::createConsumer(['payment-member-success'])
        //     ->withHandler(function (KafkaConsumerMessage $message) {
        //         event(new PaymentMemberReceived(json_encode($message->getBody())));
        //         $this->info('Received message: ' . json_encode($message->getBody()));
        //     })->build();

        $consumer = Kafka::createConsumer(['payment-success', 'payment-member-success'])
            ->withHandler(function (KafkaConsumerMessage $message) {
                if ($message->getTopicName() === 'payment-success') {
                    event(new PaymentDataReceived(json_encode($message->getBody())));
                } elseif ($message->getTopicName() === 'payment-member-success') {
                    event(new PaymentMemberReceived(json_encode($message->getBody())));
                }
                $this->info('Received message from ' . $message->getTopicName() . ': ' . json_encode($message->getBody()));
        })->build();

        $consumer->consume();
    }
}