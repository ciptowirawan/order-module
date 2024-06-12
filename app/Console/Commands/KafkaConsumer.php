<?php

namespace App\Console\Commands;

use App\Events\PaymentDataReceived;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumer extends Command
{
    protected $signature = 'kafka:consume';
    protected $description = 'Consume messages from Kafka topics';

    public function handle()
    {
        $consumer = Kafka::createConsumer(['payment-success'])
            ->withHandler(function (KafkaConsumerMessage $message) {
                event(new PaymentDataReceived(json_encode($message->getBody())));
                $this->info('Received message: ' . json_encode($message->getBody()));
            })->build();

        $consumer->consume();
    }
}