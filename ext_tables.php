<?php

if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

// Add Page TS Config

$pageTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TsConfig/Page/config.ts');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig($pageTsConfig);

// Save hooks

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'Tev\\Tev\\Hook\\PageSaveHook';

// Add new cache type to clear RealURL config

$TYPO3_CONF_VARS['SC_OPTIONS']['additionalBackendItems']['cacheActions'][] = 'Tev\\Tev\\Url\\CacheMenu';

// Register ajax call for RealURL cache clearing

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
    'TevTevAjax::clearRealurlConfig',
    'Tev\\Tev\\Ajax\\Handler->clearRealurlConfig'
);
