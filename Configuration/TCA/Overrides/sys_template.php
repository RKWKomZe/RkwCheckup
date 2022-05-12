<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        
        //=================================================================
        // Add TypoScript
        //=================================================================
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'rkw_checkup',
            'Configuration/TypoScript',
            'RKW CheckUp'
        );
    }
);