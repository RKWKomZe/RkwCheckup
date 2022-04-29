<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.RkwCheckup',
            'Check',
            'RKW Checkup: Check'
        );

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'RKW.RkwCheckup',
                'web', // Make module a submodule of 'web'
                'statistics', // Submodule key
                'before:evaluation', // Position
                [
                    'Backend' => 'list, show',
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:rkw_checkup/ext_icon.gif',
                    'labels' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_statistics.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('rkw_checkup', 'Configuration/TypoScript', 'RKW Checkup');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_checkup', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_checkup.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_checkup');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_section', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_section.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_section');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_step', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_step.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_step');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_question', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_question.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_question');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_answer', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_answer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_answer');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_result', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_result.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_result');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_stepfeedback', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_stepfeedback.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_stepfeedback');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_resultanswer', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_resultanswer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_resultanswer');

    }
);

$GLOBALS['TBE_STYLES']['skins']['rkw_checkup']['stylesheetDirectories'][] = 'EXT:rkw_checkup/Resources/Public/Styles/Backend/';
