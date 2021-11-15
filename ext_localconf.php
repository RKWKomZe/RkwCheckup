<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.RkwCheckup',
            'Check',
            [
                'Checkup' => 'list, show, new, create'
            ],
            // non-cacheable actions
            [
                'Checkup' => 'create'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    check {
                        icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('rkw_checkup') . 'Resources/Public/Icons/user_plugin_check.svg
                        title = LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkw_checkup_domain_model_check
                        description = LLL:EXT:rkw_checkup/Resources/Private/Language/locallang_db.xlf:tx_rkw_checkup_domain_model_check.description
                        tt_content_defValues {
                            CType = list
                            list_type = rkwcheckup_check
                        }
                    }
                }
                show = *
            }
       }'
    );
    }
);
