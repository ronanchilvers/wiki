<?php

namespace App\Handler;

use App\Handler\HandlerInterface;
use App\Traits\HandlerTrait;
use Monolog\Logger;
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
        $this->log(
            Logger::INFO,
            'Got name from request',
            [
                'name' => $name
            ]
        );

        return $this->render(
            new Response(),
            'home.twig',
            ['name' => $name]
        );
    }
}
