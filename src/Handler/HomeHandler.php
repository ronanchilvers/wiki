<?php

namespace App\Handler;

use App\Handler\HandlerInterface;
use App\Traits\HandlerTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

/**
 * Handler for the home page
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class HomeHandler implements HandlerInterface
{
    use HandlerTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getAttribute('name', 'world');
        $response = new Response();
        $response->getBody()->write("Hello $name");

        return $response;
    }
}
