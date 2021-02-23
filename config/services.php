<?php
// Add services

use App\Twig\GlobalsExtension;
use App\Twig\LinksExtension;
use League\Flysystem\Filesystem;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
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

    Twig::class => function (ContainerInterface $c): Twig {
        $settings = $c->get('settings');
        $twig = Twig::create(
            __DIR__ . '/../templates',
            [
                'cache' => 'development' == $settings['env'] ? false : __DIR__ . '/../var/cache'
            ]
        );
        $flash = false;
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
        $twig->addExtension(
            new GlobalsExtension([
                'debug'    => $c->get('settings')['displayErrorDetails'],
                'flash'    => $flash,
                'settings' => $settings,
            ])
        );
        $twig->addExtension(
            new LinksExtension()
        );

        return $twig;
    },

    Filesystem::class => function (ContainerInterface $c): Filesystem {
        $settings = $c->get('settings');
        $adapter = new League\Flysystem\Local\LocalFilesystemAdapter(
            $settings['data']['path']
        );

        return new Filesystem(
            $adapter
        );
    },

];
