<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Hook into RealURL config generation
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['tev'] = 'Tx_Tev_Url_AutoConfigurationGenerator->updateConfig';

// Automatically include TypoScript dependencies
Tx_Flux_Core::addGlobalTypoScript('EXT:css_styled_content/static');
Tx_Flux_Core::addGlobalTypoScript('EXT:fluidpages/Configuration/TypoScript');
Tx_Flux_Core::addGlobalTypoScript('EXT:fluidcontent/Configuration/TypoScript');
Tx_Flux_Core::addGlobalTypoScript('EXT:tev/Configuration/TypoScript');
