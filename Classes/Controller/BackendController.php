<?php
namespace RKW\RkwCheckup\Controller;

use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Service\ResultService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
/***
 *
 * This file is part of the "RKW Checkup" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * BackendController
 */
class BackendController extends ActionController
{
    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @inject
     */
    protected $checkupRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $checkups = $this->checkupRepository->findAll();
        $this->view->assign('checkups', $checkups);
    }

    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function showAction(Checkup $checkup)
    {
        $this->view->assign('checkup', $checkup);
    }

}
