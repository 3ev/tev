<?php

if (!defined ('TYPO3_MODE')) {
    die('Access denied.');
}

// Automatically include TypoScript dependencies

\FluidTYPO3\Flux\Core::addStaticTypoScript('EXT:css_styled_content/static/');
\FluidTYPO3\Flux\Core::addStaticTypoScript('EXT:tev/Configuration/TypoScript');

// Hook into RealURL config generation

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['tev'] = 'Tev\\Tev\\Hook\\RealUrlAutoConfigurationHook->updateConfig';
