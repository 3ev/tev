<?php

/**
 * Used to clear the config caches for URLs.
 */
class Tx_Tev_Url_Cache
{
    /**
     * Clear cached RealURL config.
     */
    public function clear()
    {
        unlink(PATH_site . 'typo3conf/realurl_autoconf.php');
    }
}
