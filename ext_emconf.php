<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '3ev Core',
    'description' => 'Core functionality for all 3ev extensions',
    'category' => 'misc',
    'author' => 'Ben Constable',
    'author_email' => 'benconstable@3ev.com',
    'author_company' => '3ev',
    'shy' => 0,
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.0.0-7.3.x',
            'php' => '5.5.0-5.5.x',
            'flux' => '7.2.1-7.2.X',
            'fluidcontent' => '"4.2.4-"4.2.x',
            'fluidpages' => '3.2.3-3.2.x',
            'vhs' => '2.3.3-2.3.x',
            'cms' => ''
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
