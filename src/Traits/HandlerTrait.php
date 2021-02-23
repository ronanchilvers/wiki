<?php

namespace App\Traits;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;

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
     * @var \Twig\Environment
     */
    private $twig = null;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(LoggerInterface $log, Environment $twig)
    {
        $this->log = $log;
        $this->twig = $twig;
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
        ResponseInterface $response,
        string $template,
        array $params = []
    ): ResponseInterface {
        $response->getBody()->write(
            $this->twig->render(
                $template,
                $params
            )
        );

        return $response;
    }
}
