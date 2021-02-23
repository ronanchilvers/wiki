<?php

namespace App\Twig;

use App\Facades\Security;
use App\Model\Project;
use App\Provider\Factory;
use App\Security\Manager;
use Carbon\Carbon;
use Ronanchilvers\Foundation\Traits\Optionable;
use Ronanchilvers\Utility\Str;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

/**
 * Twig extension for user helper methods
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class LinksExtension extends AbstractExtension
{
    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'edit_link',
                [$this, 'editLink']
            ),
            new TwigFunction(
                'view_link',
                [$this, 'viewLink']
            ),
            new TwigFunction(
                'new_link',
                [$this, 'newLink']
            ),

            new TwigFunction(
                'is_editing',
                [$this, 'isEditing']
            ),
            new TwigFunction(
                'is_creating',
                [$this, 'isCreating']
            ),
        ];
    }

    /**
     * Generate a view link
     *
     * @param string $url
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function viewLink($url)
    {
        $parts = explode('/', ltrim($url, '/'));
        $last = array_pop($parts);
        if (false === strpos($last, ':')) {
            $parts[] = $last;
        }

        return '/' . implode('/', $parts);
    }

    /**
     * Generate an edit link
     *
     * @param string $url
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function editLink($url): string
    {
        $parts = explode('/', ltrim($url, '/'));
        $last = array_pop($parts);
        if ($last !== 'admin:edit') {
            $parts[] = $last;
        }
        $parts[] = 'admin:edit';
        $parts = array_filter($parts);

        return '/' . implode('/', $parts);
    }

    /**
     * Generate a new page link
     *
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function newLink($url): string
    {
        if (false !== strpos($url, 'admin::create')) {
            return $url;
        }
        if (empty($url) || '/' == $url) {
            return '/admin:create';
        }
        $url = ltrim($url);

        return "/{$url}/admin:create";
    }

    /**
     * Are we currently editing a page?
     *
     * @param string $url
     * @return bool
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function isEditing($url): bool
    {
        if (false !== strpos($url, 'admin:edit')) {
            return true;
        }

        return false;
    }

    /**
     * Are we currently creating a page?
     *
     * @param string $url
     * @return bool
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function isCreating($url): bool
    {
        if (false !== strpos($url, 'admin:create')) {
            return true;
        }

        return false;
    }
}
