<?php

namespace App;

use Ronanchilvers\Utility\Str as BaseStr;

/**
 * String utility class
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Str extends BaseStr
{
    /**
     * Sanitize a title into a filename
     *
     * @param string $title
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function urlise(string $title): string
    {
        $title = preg_replace(
            '/[^A-z0-9]+/',
            '_',
            $title
        );

        return strtolower($title);
    }
}
