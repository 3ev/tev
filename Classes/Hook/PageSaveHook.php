<?php
namespace Tev\Tev\Hook;

use Tev\Tev\Url\Cache;

/**
 * Hook for saving pages.
 */
class PageSaveHook
{
    /**
     * After a page is saved, check if it is new or if its RealURL config has
     * been changed.
     *
     * If it has, clear the RealURL config cache.
     *
     * @param  string                                   $status     'new' for new entities, 'update' for existing entities
     * @param  string                                   $table      Database table name being saved
     * @param  int                                      $id         UID of New ID of entity being saved
     * @param  array                                    $fieldArray Array of fields being updated
     * @param  \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     * @return void
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, &$pObj)
    {
        if ($table === 'pages') {
            if (($status === 'new') ||
                isset($fieldArray['tx_tev_realurl_extbase_extension']) ||
                isset($fieldArray['tx_tev_realurl_extbase_plugin']) ||
                isset($fieldArray['tx_tev_realurl_extbase_inc_controller']) ||
                isset($fieldArray['tx_tev_realurl_extbase_inc_action']) ||
                isset($fieldArray['tx_tev_realurl_extbase_args'])
            ) {
                (new Cache)->clear();
            }
        }
    }
}
