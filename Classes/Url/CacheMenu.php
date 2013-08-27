<?php

/**
 * Used to add a new cache type to the backend dropdown.
 */
class Tx_Tev_Url_CacheMenu implements \TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface
{
    /**
     * Add new cache menu option.
     * 
     * @param array  $params
     * @param object $reference
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {        
        $cacheActions[] = array(
            'id'    => 'tev_cache_url',
            'title' => 'Clear generated RealURL config',
            'href' => 'ajax.php?ajaxID=tx_tev::clearcacheurl'
        );
        
        $optionValues[] = 'clearCacheTevUrl';
    }
}
