<?php
// Add services

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;

return [

    LoggerInterface::class => function (ContainerInterface $c): Logger {
        $settings = $c->get('settings');

        $loggerSettings = $settings['logger'];
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },

    Environment::class => function (ContainerInterface $c) use ($settings): Environment {
        $loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
        $twig = new Twig\Environment($loader, [
            __DIR__ . '/../var/cache'
        ]);
        if ($settings['env'] === 'development') {
            $twig->enableDebug();
        }
        return $twig;
    }

];
