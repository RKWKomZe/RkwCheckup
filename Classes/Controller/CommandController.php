<?php

namespace RKW\RkwCheckup\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Model\StepFeedback;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * CommandController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * objectManager
     *
     * @var ObjectManager
     */
    protected $objectManager;


    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @inject
     */
    protected $checkupRepository = null;

    /**
     * sectionRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\SectionRepository
     * @inject
     */
    protected $sectionRepository = null;

    /**
     * stepRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\StepRepository
     * @inject
     */
    protected $stepRepository = null;

    /**
     * questionRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = null;

    /**
     * answerRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\AnswerRepository
     * @inject
     */
    protected $answerRepository = null;

    /**
     * resultRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     * @inject
     */
    protected $resultRepository = null;

    /**
     * resultAnswerRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\ResultAnswerRepository
     * @inject
     */
    protected $resultAnswerRepository = null;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Initialize the controller.
     */
    protected function initializeController()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }


    /**
     * Cleanup checkup results of deleted checkups (Removes deleted checks and their results)
     * !! DANGER !! Cleanup executes a real MySQL-Delete- Query!!!
     *
     * @param integer $daysFromNow Defines which datasets (in days from now) will be deleted (crdate is reference)
     * @return void
     */
    public function cleanupDeletedCommand($daysFromNow = 30)
    {
        try {

            if ($cleanupTimestamp = time() - intval($daysFromNow) * 24 * 60 * 60) {

                if (
                    ($checkupList = $this->checkupRepository->findDeleted($cleanupTimestamp))
                    && is_countable($checkupList)
                    && (count($checkupList))
                ) {

                    /** @var Checkup $checkup */
                    foreach ($checkupList as $checkup) {

                        $resultList = $this->resultRepository->findByCheckupAlsoDeleted($checkup);

                        // ######################################################
                        // 1. remove result with its resultAnswers
                        // ######################################################

                        /** @var Result $result */
                        foreach ($resultList as $result) {

                            /** @var ResultAnswer $resultAnswer */
                            foreach ($result->getResultAnswer() as $resultAnswer) {

                                // 1.1 remove resultAnswer
                                GeneralUtility::makeInstance(ConnectionPool::class)
                                    ->getConnectionForTable('tx_rkwcheckup_domain_model_resultanswer')
                                    ->delete(
                                        'tx_rkwcheckup_domain_model_resultanswer', // from
                                        [ 'uid' => (int)$resultAnswer->getUid() ] // where
                                    );
                            }

                            // 1.2 remove result
                            GeneralUtility::makeInstance(ConnectionPool::class)
                                ->getConnectionForTable('tx_rkwcheckup_domain_model_result')
                                ->delete(
                                    'tx_rkwcheckup_domain_model_result', // from
                                    [ 'uid' => (int)$result->getUid() ] // where
                                );
                        }

                        // ######################################################
                        // 2. remove check with it's components
                        // ######################################################

                        $sectionList = $this->sectionRepository->findByCheckupAlsoDeleted($checkup);
                        /** @var Section $section */
                        foreach ($sectionList as $section) {

                            $stepList = $this->stepRepository->findBySectionAlsoDeleted($section);
                            /** @var Step $step */
                            foreach ($stepList as $step) {

                                $questionList = $this->questionRepository->findByStepAlsoDeleted($step);
                                /** @var Question $question */
                                foreach ($questionList as $question) {

                                    $answerList = $this->answerRepository->findByQuestionAlsoDeleted($question);
                                    /** @var Answer $answer */
                                    foreach ($answerList as $answer) {
                                        // 2.1 remove answer
                                        GeneralUtility::makeInstance(ConnectionPool::class)
                                            ->getConnectionForTable('tx_rkwcheckup_domain_model_answer')
                                            ->delete(
                                                'tx_rkwcheckup_domain_model_answer', // from
                                                [ 'uid' => (int)$answer->getUid() ] // where
                                            );
                                    }

                                    // 2.2 remove question
                                    GeneralUtility::makeInstance(ConnectionPool::class)
                                        ->getConnectionForTable('tx_rkwcheckup_domain_model_question')
                                        ->delete(
                                            'tx_rkwcheckup_domain_model_question', // from
                                            [ 'uid' => (int)$question->getUid() ] // where
                                        );

                                }

                                // 2.3 remove stepFeedback
                                if ($step->getStepFeedback() instanceof StepFeedback) {
                                    GeneralUtility::makeInstance(ConnectionPool::class)
                                        ->getConnectionForTable('tx_rkwcheckup_domain_model_stepfeedback')
                                        ->delete(
                                            'tx_rkwcheckup_domain_model_stepfeedback', // from
                                            [ 'uid' => (int)$step->getStepFeedback()->getUid() ] // where
                                        );
                                }

                                // 2.4 remove step
                                GeneralUtility::makeInstance(ConnectionPool::class)
                                    ->getConnectionForTable('tx_rkwcheckup_domain_model_step')
                                    ->delete(
                                        'tx_rkwcheckup_domain_model_step', // from
                                        [ 'uid' => (int)$step->getUid() ] // where
                                    );
                            }

                            // 2.5 remove section
                            GeneralUtility::makeInstance(ConnectionPool::class)
                                ->getConnectionForTable('tx_rkwcheckup_domain_model_section')
                                ->delete(
                                    'tx_rkwcheckup_domain_model_section', // from
                                    [ 'uid' => (int)$section->getUid() ] // where
                                );

                        }

                        // FINALLY
                        // 2.6 remove checkup
                        GeneralUtility::makeInstance(ConnectionPool::class)
                            ->getConnectionForTable('tx_rkwcheckup_domain_model_checkup')
                            ->delete(
                                'tx_rkwcheckup_domain_model_checkup', // from
                                [ 'uid' => (int)$checkup->getUid() ] // where
                            );
                    }

                } else {
                    $this->getLogger()->log(LogLevel::INFO, 'Nothing to clean up in database (cleanupDeletedCommand).');
                }
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(LogLevel::ERROR, sprintf('An error occured: %s', $e->getMessage()));
        }
    }


    /**
     * Returns logger instance
     *
     * @return Logger
     */
    protected function getLogger()
    {
        if (!$this->logger instanceof Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}