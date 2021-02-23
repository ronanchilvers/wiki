<?php

use DI\Bridge\Slim\Bridge;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestHandler;

require __DIR__ . '/../vendor/autoload.php';

$settings = require(__DIR__ . '/../config/settings.php');

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(include(__DIR__ . '/../config/services.php'));
$builder->addDefinitions([
    'settings' => $settings,
]);
$builder->enableCompilation(__DIR__ . '/../var/container');
$builder->useAutowiring(true);
$builder->useAnnotations(false);

AppFactory::setContainer($builder->build());
$app = AppFactory::create();
// $app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));

// $app->addRoutingMiddleware();
// $app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

include(__DIR__ . '/../config/routes.php');

$app->run();
