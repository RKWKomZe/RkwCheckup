<?php
return [
    'ctrl' => [
        'hideTable' => true,
        'title' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_resultanswer',
        'label' => 'answer',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'free_numeric_input,free_text_input,answer,question,step,section',
        'iconfile' => 'EXT:rkw_checkup/Resources/Public/Icons/tx_rkwcheckup_domain_model_resultanswer.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'free_numeric_input, free_text_input, answer, question, step, section, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_rkwcheckup_domain_model_resultanswer',
                'foreign_table_where' => 'AND tx_rkwcheckup_domain_model_resultanswer.pid=###CURRENT_PID### AND tx_rkwcheckup_domain_model_resultanswer.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => false,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'free_numeric_input' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_answer.free_numeric_input',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'eval' => 'int'
            ],
        ],
        'free_text_input' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_answer.free_text_input',
            'config' => [
                'type' => 'input',
                'size' => 100,
                'eval' => 'trim'
            ],
        ],
        'answer' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_resultanswer.answer',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_answer',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'question' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_resultanswer.question',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_question',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'step' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_resultanswer.step',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_step',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'section' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkwcheckup_domain_model_resultanswer.section',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwcheckup_domain_model_section',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],

    ],
];
