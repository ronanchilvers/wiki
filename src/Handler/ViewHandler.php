<?php

namespace App\Handler;

use App\Handler\HandlerInterface;
use App\Traits\HandlerTrait;
use Exception;
use Michelf\MarkdownExtra;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Str;
use Slim\Psr7\Response;

/**
 * Handler for the viewing pages
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class ViewHandler implements HandlerInterface
{
    use HandlerTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $title = $request->getAttribute('title', 'home');
        $filename = Str::urlise($title) . '.md';
        if (!$this->filesystem()->fileExists($filename)) {
            $this->flash(
                'warning',
                "Creating a new page for non-existent key '{$title}'"
            );
            return $this->redirect(
                $this->newLink($title)
            );
            // throw new Exception("No content found for '" . $title . "'");
        }
        $content = $this->filesystem()->read($filename);
        $content = preg_replace_callback(
            '#[\[]{2}([^\]]+)[\]]{2}#',
            function ($matches) {
                $title = $matches[1];
                $snake = Str::urlise($title);

                return "[{$title}](/{$snake})";
            },
            $content
        );
        $content = MarkdownExtra::defaultTransform(
            $content
        );

        return $this->render(
            'view.twig',
            ['content' => $content]
        );
    }
}
