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
    /**
    * Returns needle position if a string contains a particular substring
    * 
    * @param string $needle
    * @param string $haystack
    *
    * @return mixed
    */
    public function str_contains($needle, $haystack)
    {
        return (strpos($haystack, $needle) !== false);
    }
    
    /**
    * Recursively checks a multidimensional array to see if a key exists, returnign it if it does
    *
    * @param string $needle
    * @param array $haystack
    *
    * @return mixed
    */
    function array_key_exists_recursive($needle, $haystack)
    {
        $result = array_key_exists($needle, $haystack);
        if ($result) return $result;

        foreach ($haystack as $v) {
            if (is_array($v)) {
                $result = array_key_exists_recursive($needle, $v);
            }
            if ($result) return $result;
        }
        return $result;
    }
}

