<?php
return [
    'ctrl' => [
        'hideTable' => true,
        'title' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question',
        'label' => 'title',
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
        'searchFields' => 'record_type, title, description, mandatory, invert_feedback, allow_text_input, title_text_input, sum_to_100, min_check, 
                            max_check, scale_left, scale_right, answer, hide_cond, standard_feedback', 
        'iconfile' => 'EXT:rkw_checkup/Resources/Public/Icons/tx_rkwcheckup_domain_model_question.gif',
        'type' => 'record_type',

    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, record_, title, description, mandatory, invert_feedback, allow_text_input, 
        title_text_input, sum_to_100, min_check, max_check, max_scale, scale_left, scale_right, hide_cond, answer, standard_feedback',
    ],
    'types' => [
        '1' => [
            'showitem' => 'record_type, title, description, mandatory, --palette--;;freeTextPalette, answer, 
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend2, invert_feedback, standard_feedback,
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend, hide_cond,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden
            '],
        '2' => [
            'showitem' => 'record_type, title, description, mandatory, scale_max, scale_left, scale_right,
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend2, invert_feedback, standard_feedback,
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend, hide_cond,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden
            '],
        '3' => [
            'showitem' => 'record_type, title, description, --palette--;;freeTextPalette, min_check, max_check, answer, 
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend2, invert_feedback, standard_feedback,
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend, hide_cond,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden
            '],
    ],
    'palettes' => [
        'freeTextPalette' => [
            'showitem' => 'allow_text_input, title_text_input',
        ],
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
            'exclude' => false,
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
        'record_type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.record_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 3,
                'items' => [
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.record_type.I.1', 1],
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.record_type.I.2', 2],
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.record_type.I.3', 3],
                ],
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required'
            ],
            'onChange' => 'reload'
        ],
        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim'
            ]
        ],
        'mandatory' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.mandatory',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'invert_feedback' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.invert_feedback',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 1,
            ]
        ],
        'allow_text_input' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.allow_text_input',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 1,
            ]
        ],
        'title_text_input' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.title_text_input',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'min_check' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.min_check',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int',
                'default' => 0,
                /*'slider' => [
                    'step' => 1,
                    'width' => 200,
                ],*/
                'range' => [
                    'lower' => 0,
                    'upper' => 20,
                ]
            ]
        ],
        'max_check' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.max_check',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int',
                'default' => 0,
                /*'slider' => [
                    'step' => 1,
                    'width' => 200,
                ],*/
                'range' => [
                    'lower' => 0,
                    'upper' => 20,
                ]
            ]
        ],
        'scale_left' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.scale_left',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'scale_right' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.scale_right',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'scale_max' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.scale_max',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int',
                'default' => 3,
                /*'slider' => [
                    'step' => 1,
                    'width' => 200,
                ],*/
                'range' => [
                    'lower' => 3,
                    'upper' => 10,
                ]
            ]
        ],
        'answer' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.answer',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_answer',
                'foreign_field' => 'question',
                'foreign_sortby' => 'sorting',
                'minitems' => 2,
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'new' => true,
                        'dragdrop' => true,
                        'sort' => true,
                    ],
                ],
            ]
        ],
        'hide_cond' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.hide_cond',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => 'RKW\\RkwCheckup\\UserFunctions\\TcaProcFunc->getAnswerList',
                'maxitems'      => 99,
                'minitems'      => 0,
                'size'          => 5,
            ],
        ],
        'standard_feedback' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.standard_feedback',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim'
            ]
        ],    
        'step' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
