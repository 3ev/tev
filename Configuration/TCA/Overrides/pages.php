<?php

if (!defined ('TYPO3_MODE')) {
    die('Access denied.');
}

// Add config for RealURL Extbase

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', [
    'tx_tev_realurl_extbase_extension' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_realurl_extbase_extension',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],
    'tx_tev_realurl_extbase_plugin' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_realurl_extbase_plugin',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],
    'tx_tev_realurl_extbase_inc_controller' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_realurl_extbase_inc_controller',
        'config' => [
            'type' => 'check',
            'default' => 0
        ]
    ],
    'tx_tev_realurl_extbase_inc_action' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_realurl_extbase_inc_action',
        'config' => [
            'type' => 'check',
            'default' => 0
        ]
    ],
    'tx_tev_realurl_extbase_args' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_realurl_extbase_args',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],
    'tx_tev_menu_use_db' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_menu_use_db',
        'config' => [
            'type' => 'check',
            'default' => 0
        ]
    ],
    'tx_tev_menu_table' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_menu_table',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],
    'tx_tev_menu_field' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_menu_field',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ],
    'tx_tev_menu_request_var' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:tev/Resources/Private/Language/locallang.xml:pages.tx_tev_menu_request_var',
        'config' => [
            'type' => 'input',
            'size' => 30
        ]
    ]
]);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;Extbase RealURL Config, tx_tev_realurl_extbase_extension, tx_tev_realurl_extbase_plugin, tx_tev_realurl_extbase_inc_controller, tx_tev_realurl_extbase_inc_action, tx_tev_realurl_extbase_args,--div--;Extra Menu Config, tx_tev_menu_use_db, tx_tev_menu_table, tx_tev_menu_field, tx_tev_menu_request_var',
    '0,1,4'
);
