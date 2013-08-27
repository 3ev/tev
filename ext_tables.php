<?php

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Add config for RealURL fixedPostVars
ExtensionManagementUtility::addTCAcolumns('pages', array(
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
ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    'tx_tev_postvars, tx_tev_childpostvars',
    '0,1,4',
    'after:tx_realurl_exclude'
);
