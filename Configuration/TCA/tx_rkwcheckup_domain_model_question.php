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
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'type,title,description,mandatory,sum_to_100,min_check,max_check,scale_left,scale_right,answer,hide_cond',
        'iconfile' => 'EXT:rkw_checkup/Resources/Public/Icons/tx_rkwcheckup_domain_model_question.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, description, mandatory, sum_to_100, min_check, max_check, scale_left, scale_right, hide_cond, answer',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                title, description, mandatory, sum_to_100, min_check, max_check, scale_left, scale_right, answer, 
                --div--;LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.tab.extend, hide_cond,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden
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
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 1,
                'items' => [
                    //['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type.I.0', 0],
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type.I.1', 1],
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type.I.2', 2],
                    ['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type.I.3', 3],
                    //['LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.type.I.4', 4],
                ],
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required'
            ],
            'onChange' => 'reload'
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim'
            ]
        ],
        'mandatory' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.mandatory',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ],
            'displayCond' => [
                'OR' => [
                    'FIELD:type:=:1',
                    'FIELD:type:=:2',
                ],
            ],
        ],
        'sum_to_100' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.sum_to_100',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ],
            'displayCond' => 'FIELD:type:=:4',

        ],
        'min_check' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.min_check',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int',
                'default' => 0,
                'slider' => [
                    'step' => 1,
                    'width' => 200,
                ],
                'range' => [
                    'lower' => 0,
                    'upper' => 20,
                ]
            ],
            'displayCond' => [
                'OR' => [
                    'FIELD:type:=:3',
                    'FIELD:type:=:4',
                ],
            ],
        ],
        'max_check' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.max_check',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int',
                'default' => 0,
                'slider' => [
                    'step' => 1,
                    'width' => 200,
                ],
                'range' => [
                    'lower' => 0,
                    'upper' => 20,
                ]
            ],
            'displayCond' => [
                'OR' => [
                    'FIELD:type:=:3',
                    'FIELD:type:=:4',
                ],
            ],
        ],
        'scale_left' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.scale_left',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:type:=:2',
        ],
        'scale_right' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_question.scale_right',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'displayCond' => 'FIELD:type:=:2',
        ],
        'answer' => [
            'exclude' => true,
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
            ],
        ],
        'hide_cond' => [
            'exclude' => true,
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
    
        'question_container' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
