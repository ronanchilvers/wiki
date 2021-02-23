<?php

namespace App\Handler;

use App\Handler\HandlerInterface;
use App\Str;
use App\Traits\HandlerTrait;
use Exception;
use Michelf\MarkdownExtra;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

/**
 * Handler for creating pages
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class NewHandler implements HandlerInterface
{
    use HandlerTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $title = $request->getAttribute('title', '');;
        $content = '';
        if ('POST' == $request->getMethod()) {
            try {
                $data = $request->getParsedBody();
                $title = $data['title'];
                if (empty($title)) {
                    throw new Exception("Page key can't be empty");
                }
                $title = Str::urlise($title);
                $filename = $title . '.md';
                if ($this->filesystem()->fileExists($filename)) {
                    throw new Exception("Page exists '" . $title . "'");
                }
                $this->filesystem()->write(
                    $filename,
                    $data['content']
                );
                $this->flash(
                    'success',
                    "Page saved ok"
                );
                return $this->redirect(
                    $this->editLink($title)
                );
            } catch (Exception $ex) {
                $this->flash(
                    'danger',
                    $ex->getMessage()
                );
                return $this->redirect(
                    $this->newLink()
                );
            }
        }

        return $this->render(
            'edit.twig',
            [
                'title'   => $title,
                'content' => $content,
                'action'  => $this->newLink(),
            ]
        );
    }
}
