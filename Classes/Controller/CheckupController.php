<?php
namespace RKW\RkwCheckup\Controller;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Service\ResultService;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
class CheckupController extends \RKW\RkwAjax\Controller\AjaxAbstractController
{
    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @inject
     */
    protected $checkupRepository = null;

    /**
     * resultRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     * @inject
     */
    protected $resultRepository = null;

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
     * action new
     *
     * @param int $terms
     * @return void
     */
    public function newAction($terms = 0)
    {
        // check terms
        if (!$terms) {
            $this->addFlashMessage(
                LocalizationUtility::translate(
                    'checkupController.warning.terms',
                    'rkw_checkup'
                ),
                null,
                AbstractMessage::ERROR
            );
            $this->redirect('index');
        }

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
            $this->redirect('result', null, null, ['result' => $result]);
        }

        $this->view->assign('result', $result);
    }

    /**
     * initializeValidateAction
     * Remove all not selected answers (would otherwise throw an error)
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidArgumentNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function initializeValidateAction()
    {
        if ($this->request->hasArgument('result')) {
            $result = $this->request->getArgument('result');

            if (
                is_array($result)
                && is_array($result['newResultAnswer'])
            ) {

                // remove empty entries
                foreach ($result['newResultAnswer'] as $key => $answer) {

                    if (
                        is_array($answer)
                        && (
                            !key_exists('answer', $answer)
                            || (
                                is_array($answer['answer'])
                                && !$answer['answer']['__identity']
                            )
                        )
                    ) {
                        // but not if it's special answer type
                        if (!key_exists('freeNumericInput', $answer)) {
                            unset($result['newResultAnswer'][$key]);
                        }
                    }
                }

                DebuggerUtility::var_dump($result); exit;

                // override
                $this->request->setArgument('result', $result);
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
        if ($this->resultService->progressValidation()){
            $this->resultService->moveNewResultAnswers();
            $this->resultService->setNextStep();
            $this->resultService->persist();
        }

        $this->forward('progress', null, null, ['result' => $result]);
    }

    /**
     * action result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function resultAction(Result $result)
    {
        if (!$result->isFinished()) {
            $this->forward('progress', null, null, ['result' => $result]);
        }

        $this->view->assign('result', $result);
    }


}
