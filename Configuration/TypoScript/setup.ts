
plugin.tx_rkwcheckup {
    view {
        templateRootPaths.0 = EXT:{extension.extensionKey}/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_rkwcheckup_check.view.templateRootPath}
        partialRootPaths.0 = EXT:rkw_checkup/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_rkwcheckup_check.view.partialRootPath}
        layoutRootPaths.0 = EXT:rkw_checkup/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_rkwcheckup_check.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_rkwcheckup_check.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

# plugin
plugin.tx_rkwcheckup_check < plugin.tx_rkwcheckup

# these classes are only used in auto-generated templates
plugin.tx_rkwcheckup._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-rkw-checkup table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-rkw-checkup table th {
        font-weight:bold;
    }

    .tx-rkw-checkup table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

# Module configuration
module.tx_rkwcheckup_web_rkwcheckupstatistics {
    persistence {
        storagePid = {$module.tx_rkwcheckup_statistics.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:{extension.extensionKey}/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_rkwcheckup_statistics.view.templateRootPath}
        partialRootPaths.0 = EXT:rkw_checkup/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_rkwcheckup_statistics.view.partialRootPath}
        layoutRootPaths.0 = EXT:rkw_checkup/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_rkwcheckup_statistics.view.layoutRootPath}
    }
}
