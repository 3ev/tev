<?php

namespace Tev\Tev\Utils;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility class to bootstrap the TSFE (mostly for use in CLI modules).
 */
class Tsfe
{
    /**
     * Bootstrap TSFE.
     * 
     * @param int     $rootPageId Root page UID
     * @param boolean $setHost    Set server host too, from sys_domain table (for RealURL)
     */
    public static function create($rootPageId, $setHost = true)
    {
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TimeTracker\\TimeTracker');
            $GLOBALS['TT']->start();
        }
 
        $tsfe = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], $rootPageId, 0);
        $tsfe->initFEuser();
        $tsfe->determineId();
        $tsfe->getPageAndRootline();
        $tsfe->initTemplate();
        $tsfe->getConfigArray();
        $tsfe->newCObj();
        
        $GLOBALS['TSFE'] = $tsfe;

        if ($setHost) {
            $domains = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                'domainName',
                'sys_domain',
                'hidden = 0 AND pid = "' . $rootPageId . '"');

            if (count($domains)) {
                $_SERVER['HTTP_HOST'] = $domains[0]['domainName'];
            }
        }
    }
}
