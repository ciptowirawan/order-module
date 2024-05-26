<?php


return [
    'default' => [
        'transport' => [
            'dsn' => 'rdkafka://localhost:9092',
            'global' => [
                'group.id' => 'default',
                'metadata.broker.list' => 'localhost:9092',
            ],
            'topic' => [
                'order-created' => [],
            ],
        ],
        'client' => [
            'prefix' => 'enqueue',
            'app_name' => 'app',
            'router_topic' => 'default',
            'router_queue' => 'default',
        ],
        'extensions' => [
            'signal_extension' => true,
            'reply_extension' => true,
        ],
        'consumption' => [
            'receive_timeout' => 10000,
            'redelivered_delay_time' => 0,
        ],
    ],
];
