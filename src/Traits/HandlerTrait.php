<?php

namespace App\Traits;

/**
 * Base trait for all handlers
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
trait HandlerTrait
{
    private $logger = null;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct()
    {}
}
