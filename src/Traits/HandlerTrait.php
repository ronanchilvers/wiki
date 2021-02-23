<?php

namespace App\Traits;

use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

/**
 * Base trait for all handlers
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait HandlerTrait
{
    private $logger = null;

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
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
