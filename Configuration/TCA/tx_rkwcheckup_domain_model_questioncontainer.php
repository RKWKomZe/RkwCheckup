<?php
return [
    'ctrl' => [
        'hideTable' => true,
        'title' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_questioncontainer',
        'label' => 'starttime',
        'label_userFunc' => \RKW\RkwCheckup\UserFunctions\TcaLabel::class . '->createQuestionContainerLabel',

        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'question_type_1, question_type_2, question_type_3',
        'iconfile' => 'EXT:rkw_checkup/Resources/Public/Icons/tx_rkwcheckup_domain_model_question.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, question_type_1, question_type_2, question_type_3',
    ],
    'types' => [
        # --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden, starttime, endtime
        '1' => [
            'showitem' => '
                question_type_1, question_type_2, question_type_3, 
            '],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_rkwcheckup_domain_model_question',
                'foreign_table_where' => 'AND tx_rkwcheckup_domain_model_question.pid=###CURRENT_PID### AND tx_rkwcheckup_domain_model_question.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'question_type_1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_questioncontainer.type.I.1',
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 1
                            ],
                        ],
                    ],
                ],
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_question',
                'foreign_field' => 'question_container',
                'foreign_sortby' => 'sorting',
                'foreign_match_fields' => [
                    'type' => 1
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'useSortable' => false,
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => false,
                    ],
                ],
            ],
        ],
        'question_type_2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_questioncontainer.type.I.2',
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 2
                            ],
                        ],
                    ],
                ],
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_question',
                'foreign_field' => 'question_container',
                'foreign_sortby' => 'sorting',
                'foreign_match_fields' => [
                    'type' => 2
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'useSortable' => false,
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => false,
                    ],
                ],
            ],
        ],
        'question_type_3' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_questioncontainer.type.I.3',
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 3
                            ],
                        ],
                    ],
                ],
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_question',
                'foreign_field' => 'question_container',
                'foreign_sortby' => 'sorting',
                'foreign_match_fields' => [
                    'type' => 3
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'useSortable' => false,
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => false,
                    ],
                ],
            ],
        ],
    
        'step' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
