<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'RKW Checkup',
    'description' => '',
    'category' => 'plugin',
    'author' => 'Maximilian Fäßler',
    'author_email' => 'maximilian@faesslerweb.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '1',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '9.5.4',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'core_extended' => '9.5.4-9.5.99',
            'accelerator' => '9.5.2-9.5.99',
            'fe_register' => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
