<?php
namespace Tev\Tev\Hook;

use Tx_Tev_Url_Cache;

/**
 * Hook for saving pages.
 *
 * @author     Ben Constable <benconstable@3ev.com>, 3ev
 * @package    Tev\Tev
 * @subpackage Hook
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
            if (($status === 'new') || isset($fieldArray['tx_tev_postvars']) || isset($fieldArray['tx_tev_childpostvars'])) {
                $urlCache = new Tx_Tev_Url_Cache;
                $urlCache->clear();
            }
        }
    }
}
