<?php
return [
    'default' => [
        'transport' => [
            'dsn' => 'rdkafka://localhost:9092',
            'global' => [
                'group.id' => 'payment-service', // Adjust group.id per module
                'metadata.broker.list' => 'localhost:9092',
            ],
            'topic' => [
                'order-created' => [],
            ],
        ],
        'client' => [
            'prefix' => 'enqueue',
            'app_name' => 'payment-service',
            'router_topic' => 'default',
            'router_queue' => 'default',
        ],
        'extensions' => [
            'signal_extension' => true,
            'reply_extension' => true,
        ],
        'consumption' => [
            'receive_timeout' => 10000,
        ],
    ],
];

