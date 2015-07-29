<?php

namespace Tev\Tev\Url;

/**
 * Used to clear the config caches for URLs.
 */
class Cache
{
    /**
     * Clear cached RealURL config.
     *
     * @return void
     */
    public function clear()
    {
        $file = PATH_site . 'typo3conf/realurl_autoconf.php';

        if (file_exists($file)) {
            unlink($file);
        }
    }
}
