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
    'clearCacheOnLoad' => 0,
    'version' => '10.4.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'core_extended' => '10.4.0-12.4.99',
            'accelerator' => '10.4.0-12.4.99',
            'fe_register' => '10.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
