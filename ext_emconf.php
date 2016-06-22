<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '3ev Core',
    'description' => 'Core functionality for all 3ev extensions',
    'category' => 'misc',
    'version' => '4.0.1',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Ben Constable',
    'author_email' => 'benconstable@3ev.com',
    'author_company' => '3ev',
    'constraints' => [
        'depends' => [
            'typo3' => '7.4.0-7.999.999',
            'php' => '5.5.0-5.5.999',
            'vhs' => '2.3.3-0.0.0'
        ],
        'conflicts' => [],
        'suggests' => []
    ]
];
