<?php
namespace Tev\Tev\Ajax;

use TYPO3\CMS\Core\Http\AjaxRequestHandler;
use Tev\Tev\Url\Cache;

/**
 * Ajax handler for the tev extension.
 */
class Handler
{
    /**
     * Handle clearing the generated RealURL config file.
     *
     * @param  array                                        $params   Ajax params, currently unused
     * @param  \TYPO3\CMS\Core\Http\AjaxRequestHandler|null &$ajaxObj Ajax request handler instance
     * @return void
     */
    public function clearRealurlConfig($params = [], AjaxRequestHandler &$ajaxObj = null)
    {
        // Run the cache clearing service

        (new Cache)->clear();
    }
}
