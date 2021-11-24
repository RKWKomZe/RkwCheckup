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
 * CheckupController
 */
class CheckupController extends ActionController
{
    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @inject
     */
    protected $checkupRepository = null;

    /**
     * resultService
     *
     * @var \RKW\RkwCheckup\Service\ResultService
     */
    protected $resultService = null;

    /**
     * initializeAction
     */
    public function initializeAction()
    {
        $this->resultService = $this->objectManager->get(ResultService::class);
    }

    /**
     * action index
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('checkup', $this->checkupRepository->findByUid(intval($this->settings['checkup'])));
    }

    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function showAction(Checkup $checkup)
    {
        // NOT USED YET
        $this->view->assign('checkup', $checkup);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $checkup = $this->checkupRepository->findByUid(intval($this->settings['checkup']));
        $this->resultService->new($checkup);
        $this->resultService->persist();
        $this->view->assign('result', $this->resultService->get());
    }

    /**
     * action progress
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result
     * @return void
     */
    public function progressAction(Result $result)
    {
        $this->view->assign('result', $this->resultService->get());
    }

    /**
     * action create
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function createAction(Checkup $newCheckup)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->checkupRepository->add($newCheckup);
        $this->redirect('list');
    }

}
