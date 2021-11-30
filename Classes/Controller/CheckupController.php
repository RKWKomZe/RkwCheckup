<?php
namespace RKW\RkwCheckup\Controller;

use RKW\RkwBasics\Utility\GeneralUtility;
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
        // @toDo: Get and set Result records by hash? Would makes "set" obsolete
        // -> Needs result hash in URL

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
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $checkup = $this->checkupRepository->findByUid(intval($this->settings['checkup']));
        $this->resultService->new($checkup);
        $this->resultService->persist();

        $this->redirect('progress', null, null, ['result' => $this->resultService->get()]);
    }

    /**
     * action progress
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     */
    public function progressAction(Result $result)
    {
        if ($result->isFinished()) {
            $this->redirect('show', null, null, ['result' => $result]);
        }

        $this->view->assign('result', $result);
    }

    /**
     * initializeValidateAction
     * Remove all not selected answers
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function initializeValidateAction()
    {
        if ($this->request->hasArgument('result')) {
            $newResultAnswer = $this->request->getArgument('result');
            if (
                is_array($newResultAnswer)
                && is_array($newResultAnswer['newResultAnswer'])
            ) {

                // remove empty entries
                foreach ($newResultAnswer['newResultAnswer'] as $key => $answer) {
                    if (
                        is_array($answer)
                        && (!key_exists('answer', $answer) || !$answer['answer']['__identity'])
                    ) {
                        unset($newResultAnswer['newResultAnswer'][$key]);
                    }
                }

                // override
                $this->request->setArgument('result', $newResultAnswer);
            }
        }
    }

    /**
     * action validate
     * @validate $result \RKW\RkwCheckup\Validation\Validator\ResultValidator
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public function validateAction(Result $result)
    {
        $this->resultService->set($result);
        $this->resultService->moveNewResultAnswers();
        $this->resultService->setNextStep();
        $this->resultService->persist();

        $this->forward('progress', null, null, ['result' => $result]);
    }

    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     */
    public function showAction(Result $result)
    {
        $this->view->assign('result', $result);
    }


}
