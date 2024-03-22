<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        //=================================================================
        // Register Plugin
        //=================================================================
        ExtensionUtility::registerPlugin(
            $extKey,
            'Check',
            'RKW CheckUp: Check'
        );

        //=================================================================
        // Add Flexforms
        //=================================================================
        $extensionName = strtolower(GeneralUtility::underscoredToUpperCamelCase($extKey));
        $pluginName = strtolower('Check');
        $pluginSignature = $extensionName.'_'.$pluginName;

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:'.$extKey.'/Configuration/FlexForms/flexform_checkup.xml'
        );

    },
    'rkw_checkup'
);
