<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Add Page TS Config
$pageTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TsConfig/Page/config.ts');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig($pageTsConfig);

// Add config for RealURL fixedPostVars
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', array(
    'tx_tev_postvars' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_postvars',
        'config' => array(
            'type' => 'input',
            'size' => '30'
        )
    ),
    'tx_tev_childpostvars' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_childpostvars',
        'config' => array(
            'type' => 'input',
            'size' => '30'
        )
    )
), 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    'tx_tev_postvars, tx_tev_childpostvars',
    '0,1,4',
    'after:tx_realurl_exclude'
);
