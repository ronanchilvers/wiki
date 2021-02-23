<?php
// App settings

use Monolog\Logger;

return [
    'wiki' => [
        'name' => 'wiki',
    ],
    'env' => 'development',
    'displayErrorDetails' => true,
    'logger' => [
        'name' => 'slim-app',
        'path' => 'php://stderr',
        'level' => Logger::DEBUG,
    ],
    'data' => [
        'path' => __DIR__ . '/../data',
    ]
];
