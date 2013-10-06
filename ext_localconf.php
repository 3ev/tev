<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Automatically include TypoScript dependencies
Tx_Flux_Core::addGlobalTypoScript('EXT:css_styled_content/static');
Tx_Flux_Core::addGlobalTypoScript('EXT:fluidpages/Configuration/TypoScript');
Tx_Flux_Core::addGlobalTypoScript('EXT:fluidcontent/Configuration/TypoScript');
Tx_Flux_Core::addGlobalTypoScript('EXT:tev/Configuration/TypoScript');

// Hook into RealURL config generation
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['tev'] = 'Tev\\Tev\\Hook\\RealUrlAutoConfigurationHook->updateConfig';

// Add new cache type to clear RealURL config
$TYPO3_CONF_VARS['SC_OPTIONS']['additionalBackendItems']['cacheActions'][] = 'Tx_Tev_Url_CacheMenu';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_tev::clearcacheurl'] = 'Tx_Tev_Url_Cache->clear';
