<?php

use App\Handler\HomeHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', HomeHandler::class)
    ->setName('home');

// $app->get('/', function (Request $request, Response $response) {
//     $response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
//     return $response;
// });

// $app->get('/hello/{name}', function (Request $request, Response $response, $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");
//     return $response;
// });
