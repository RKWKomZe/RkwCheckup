<?php
namespace RKW\RkwCheckup\Controller;

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
class CheckupController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function listAction()
    {
        $checks = $this->checkupRepository->findAll();
        $this->view->assign('checks', $checks);
    }

    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function showAction(\RKW\RkwCheckup\Domain\Model\Checkup $checkup)
    {
        $this->view->assign('checkup', $checkup);
    }

    /**
     * action new
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup
     * @return void
     */
    public function createAction(\RKW\RkwCheckup\Domain\Model\Checkup $newCheckup)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->checkupRepository->add($newCheckup);
        $this->redirect('list');
    }
}
