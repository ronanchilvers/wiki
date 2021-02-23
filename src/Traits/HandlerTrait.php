<?php

namespace App\Traits;

use App\Twig\LinksExtension;
use League\Flysystem\Filesystem;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

/**
 * Base trait for all handlers
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait HandlerTrait
{
    /**
     * Logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $log = null;

    /**
     * Twig Environment object
     *
     * @var Slim\Views\Twig
     */
    private $twig = null;

    /**
     * Filesystem object
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Links Extension object
     *
     * @var \App\Twig\LinksExtension
     */
    private $linksExtension;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(
        LoggerInterface $log, 
        Twig $twig,
        Filesystem $filesystem
    ) {
        $this->log        = $log;
        $this->twig       = $twig;
        $this->filesystem = $filesystem;
        $this->linksExtension = new LinksExtension();
    }

    /**
     * Log a message
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function log($level, $message, array $context = [])
    {
        $this->log->log(
            $level,
            $message,
            $context
        );
    }

    /**
     * Render a view
     *
     * @return \Twig\Environment
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function render(
        string $template,
        array $params = [],
        ResponseInterface $response = null
    ): ResponseInterface {
        if (is_null($response)) {
            $response = new Response();
        }

        return $this->twig->render(
            $response,
            $template,
            $params
        );
    }

    /**
     * Get the local filesystem object
     *
     * @return League\Flysystem\Filesystem
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function filesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * Redirect to a given URL
     *
     * @param Psr\Http\Message\ResponseInterface $response
     * @param string $url
     * @return Psr\Http\Message\ResponseInterface
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function redirect(
        $url,
        ResponseInterface $response = null
    ): ResponseInterface {
        if (is_null($response)) {
            $response = new Response();
        }

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    /**
     * Generate an edit link
     *
     * @param string $url
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function editLink($url): string
    {
        return $this->linksExtension
            ->editLink($url);
    }

    /**
     * Generate an view link
     *
     * @param string $url
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function viewLink($url): string
    {
        return $this->linksExtension
            ->viewLink($url);
    }

    /**
     * Generate a new page link
     *
     * @param string $url
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function newLink($url = ''): string
    {
        return $this->linksExtension
            ->newLink($url);
    }

    /**
     * Send a flash message
     *
     * @param string $type
     * @param string $message
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function flash($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}
