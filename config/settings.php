<?php
// App settings

use Monolog\Logger;

return [
    'env' => 'development',
    'displayErrorDetails' => true,
    'logger' => [
        'name' => 'slim-app',
        'path' => 'php://stderr',
        'level' => Logger::DEBUG,
    ],
];
