# rkw/rkw-checkup
Extension for feedback surveys


### needed RealUrl conf (use HASH instead of UID!)
```
'tx-rkw-checkup' => array (
    array(
        'GETvar' => 'tx_rkwcheckup_check[controller]',
        'valueMap' => array(
            'checkup' => 'Checkup',
        ),
    ),
    array(
        'GETvar' => 'tx_rkwcheckup_check[action]' ,
    ),
    array(
        'GETvar' => 'tx_rkwcheckup_check[result]',
        'lookUpTable' => array(
            'table' => 'tx_rkwcheckup_domain_model_result',
            'id_field' => 'uid',
            'alias_field' => 'hash',
            'addWhereClause' => ' AND NOT deleted',
            'useUniqueCache' => 1,
            'useUniqueCache_conf' => array(
                'strtolower' => 1,
                'spaceCharacter' => '-',
            ),
        ),
    ),
),
```