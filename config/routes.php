<?php
// Add routes

use App\Handler\EditHandler;
use App\Handler\NewHandler;
use App\Handler\ViewHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

/******************************************************/
// Editing routes
$app->get('/admin:edit', function (Request $request) {
    return (new Response())
        ->withHeader('Location', '/home/admin:edit')
        ->withStatus(302);
});
$app->map(['GET', 'POST'], '/{title}/admin:edit', EditHandler::class)
    ->setName('edit');
$app->map(['GET', 'POST'], '/admin:create', NewHandler::class)
    ->setName('edit_new');
$app->map(['GET', 'POST'], '/{title}/admin:create', NewHandler::class)
    ->setName('edit_new_with_title');

/******************************************************/
// View routes
$app->get('/[{title}]', ViewHandler::class)
    ->setName('view');
