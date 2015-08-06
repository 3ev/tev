<?php
namespace Tev\Tev\Url;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;

/**
 * Used to add a new cache type to the backend dropdown.
 */
class CacheMenu implements ClearCacheActionsHookInterface
{
    /**
     * Add new cache menu option.
     *
     * @param  array $cacheActions
     * @param  array $optionValues
     * @return void
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {
        $cacheActions[] = array(
            'id' => 'tev_cache_url',
            'title' => 'Flush RealURL config',
            'href' => BackendUtility::getAjaxUrl('TevTevAjax::clearRealurlConfig'),
            'icon' => IconUtility::getSpriteIcon('actions-system-cache-clear-impact-low')
        );

        $optionValues[] = 'clearCacheTevUrl';
    }
}
