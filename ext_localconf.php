<?php

if (!defined ('TYPO3_MODE')) {
    die('Access denied.');
}

$tevConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tev']);

// Automatically include TypoScript dependencies

if (!$tevConf['disable_typoscript_autoload']) {
    \FluidTYPO3\Flux\Core::addStaticTypoScript('EXT:css_styled_content/static/');
    \FluidTYPO3\Flux\Core::addStaticTypoScript('EXT:tev/Configuration/TypoScript');
}

// Hook into RealURL config generation

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['tev'] = 'Tev\\Tev\\Hook\\RealUrlAutoConfigurationHook->updateConfig';

// Use xclass to override core Query Parser with patch

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser'] = [
   'className' => 'Tev\\Tev\\Extbase\\Persistence\\Generic\\Storage\\Typo3DbQueryParser'
];

// Configure mail logger

$GLOBALS['TYPO3_CONF_VARS']['LOG']['tevmail']['writerConfiguration'] = [
    \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
        'Tev\\Typo3Utils\\Log\\Writer\\FileWriter' => [
            'logFile' => $tevConf['mail_logfile_path'] ?: 'typo3temp/logs/tev_mail.log'
        ]
    ]
];

