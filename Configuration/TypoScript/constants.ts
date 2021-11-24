
plugin.tx_rkwcheckup_check {
    view {
        # cat=plugin.tx_rkwcheckup_check/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:rkw_checkup/Resources/Private/Templates/
        # cat=plugin.tx_rkwcheckup_check/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:rkw_checkup/Resources/Private/Partials/
        # cat=plugin.tx_rkwcheckup_check/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:rkw_checkup/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_rkwcheckup_check//a; type=string; label=Default storage PID
        storagePid =
    }
}

module.tx_rkwcheckup_statistics {
    view {
        # cat=module.tx_rkwcheckup_statistics/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:rkw_checkup/Resources/Private/Backend/Templates/
        # cat=module.tx_rkwcheckup_statistics/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:rkw_checkup/Resources/Private/Backend/Partials/
        # cat=module.tx_rkwcheckup_statistics/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:rkw_checkup/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_rkwcheckup_statistics//a; type=string; label=Default storage PID
        storagePid =
    }
}
