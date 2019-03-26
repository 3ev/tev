<?php
namespace Tev\Tev\Util;

/**
 * Miscellaneous/General utility functions
 *
 * Class Misc
 *
 * @package Tev\Tev\Util
 */
class Misc
{
    public function str_contains($needle, $haystack)
    {
        return (strpos($haystack, $needle) !== false);
    }
}

