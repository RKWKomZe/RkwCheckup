<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.RkwCheckup',
            'Check',
            [
                'Checkup' => 'index, new, progress, validate, result'
            ],
            // non-cacheable actions
            [
                'Checkup' => 'index, new, progress, validate, result'
            ]
        );
    }
);
