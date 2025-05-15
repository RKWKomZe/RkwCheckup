<?php
declare(strict_types = 1);

return [
    \RKW\RkwCheckup\Domain\Model\Result::class => [
        'tableName' => 'tx_rkwcheckup_domain_model_result',
        'properties' => [
            'tstamp' => [
                'fieldName' => 'tstamp'
            ],
            'crdate' => [
                'fieldName' => 'crdate'
            ],
            'hidden' => [
                'fieldName' => 'hidden'
            ],
            'deleted' => [
                'fieldName' => 'deleted'
            ],
        ],
    ],
];