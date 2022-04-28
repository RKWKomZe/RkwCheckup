<?php
namespace RKW\RkwCheckup\Controller;

use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Step\ProgressHandler;
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
    protected $checkupRepository;

    /**
     * resultRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     * @inject
     */
    protected $resultRepository;

    
    /**
     * action list
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return void
     */
    public function listAction(Checkup $checkup = null): void
    {
        if ($checkup) {
            $this->view->assign('checkResultList', $this->resultRepository->getFinishedByCheck($checkup));
            $this->view->assign('checkup', $checkup);
        } else {
            $this->view->assign('checkList', $this->checkupRepository->findAll());
        }
    }

    
    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function showAction(Checkup $checkup): void
    {
        $this->view->assign('checkupResultCountTotal', $this->resultRepository->getFinishedByCheck($checkup)->count());
        $this->view->assign('checkup', $checkup);
    }

}
