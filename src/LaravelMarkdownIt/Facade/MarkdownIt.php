<?php

namespace Kaoken\LaravelMarkdownIt\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Markdown
 * @package Kaoken\Markdown\Facades
 */
class MarkdownIt extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'markdownit';
    }
}
