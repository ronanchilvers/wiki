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
 * Handler for editing pages
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class EditHandler implements HandlerInterface
{
    use HandlerTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $title = $request->getAttribute('title', 'home');
        $title = Str::urlise($title);
        $filename = $title . '.md';
        if (!$this->filesystem()->fileExists($filename)) {
            throw new Exception("No content found for '" . $title . "'");
        }
        if ('POST' == $request->getMethod()) {
            try {
                $data = $request->getParsedBody();
                $newTitle = $data['title'];
                if (empty($newTitle)) {
                    throw new Exception("Page key can't be empty");
                }
                $title = Str::urlise($newTitle);
                $filename = $title . '.md';
                $this->filesystem()->write(
                    $filename,
                    $data['content']
                );
                $this->flash(
                    'success',
                    "Page saved ok"
                );
                return $this->redirect(
                    $this->viewLink($title)
                );
            } catch (Exception $ex) {
                $this->flash(
                    'danger',
                    $ex->getMessage()
                );
                return $this->redirect(
                    $this->editLink($title)
                );
            }
        }
        $content = $this->filesystem()->read($filename);

        return $this->render(
            'edit.twig',
            [
                'title'   => $title,
                'content' => $content,
                'action'  => $this->editLink($title),
            ]
        );
    }
}
