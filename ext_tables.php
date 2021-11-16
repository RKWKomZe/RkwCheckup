<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'RKW.RkwCheckup',
                'web', // Make module a submodule of 'web'
                'statistics', // Submodule key
                '', // Position
                [
                    'Checkup' => 'list, show, new, create',
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:rkw_checkup/Resources/Public/Icons/user_mod_statistics.svg',
                    'labels' => 'LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_statistics.xlf',
                ]
            );

        }


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

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwcheckup_domain_model_interimresult', 'EXT:rkw_checkup/Resources/Private/Language/locallang_csh_tx_rkwcheckup_domain_model_interimresult.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwcheckup_domain_model_interimresult');

    }
);
