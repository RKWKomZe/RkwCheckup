<?php

namespace RKW\RkwCheckup\Service;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Utility\StepUtility;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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

/**
 * Class ResultService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultService
{
    /**
     * Setting
     *
     * @var array
     */
    protected $settings;

    /**
     * @var \RKW\RkwCheckup\Domain\Model\Result
     */
    protected $result;

    /**
     * create new result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return void
     */
    public function new ($checkup)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->result = $objectManager->get(Result::class);
        $this->result->setCheckup($checkup);

        // unique ID with timestamp as prefix
        $this->result->setHash(uniqid(time()));

        // initial: Set first section & first step
        $this->result->setCurrentSection($checkup->getSection()->current());
        $this->result->setCurrentStep($checkup->getSection()->current()->getStep()->current());
    }

    /**
     * validateQuestion
     * Hint: Works with "getNewResultAnswer" (NOT with the persistent "getResultAnswer")
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return string Returns error message if something is wrong
     * @throws \Exception
     */
    public function validateQuestion ($question)
    {
        if (!$this->result) {
            throw new \Exception('No result set.', 1638189967);
        }

        // 1. Assign answers to given question
        $assignedAnswerList = [];
        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer */
        foreach ($this->result->getNewResultAnswer() as $newResultAnswer) {

            if ($question === $newResultAnswer->getQuestion()) {
                $assignedAnswerList[] = $newResultAnswer->getQuestion();
            }
        }

        // 2. Check it
        // 2.1 Mandatory
        if (
            ($question->getType() == 1 || $question->getType() == 2)
            && $question->isMandatory()
            && empty($assignedAnswerList)
        ) {
            // mandatory!
            return LocalizationUtility::translate(
                'resultService.error.mandatory',
                'rkw_checkup'
            );
        }

        // 2.2 Minimum
        if (
            $question->getType() == 3
            && $question->getMinCheck() != 0
            && $question->getMinCheck() > count($assignedAnswerList)
        ) {
            // not enough selected!
            return LocalizationUtility::translate(
                'resultService.error.min',
                'rkw_checkup',
                [$question->getMinCheck()]
            );
        }

        // 2.3 Maximum
        if (
            $question->getType() == 3
            && $question->getMaxCheck() != 0
            && $question->getMaxCheck() < count($assignedAnswerList)
        ) {
            // too much selected!
            return LocalizationUtility::translate(
                'resultService.error.max',
                'rkw_checkup',
                [$question->getMaxCheck()]
            );
        }

        // 2.4 SumTo100
        if (
            $question->getType() == 4
            && $question->isSumTo100()
        ) {
            $sumTotal = 0;
            /** @var ResultAnswer $resultAnswer */
            DebuggerUtility::var_dump($assignedAnswerList); exit;
            foreach ($assignedAnswerList as $resultAnswer) {
                $sumTotal += $resultAnswer->getFreeNumericInput();
            }

            if (!$sumTotal == 100) {
                // not enough!
                return LocalizationUtility::translate(
                    'resultService.error.sumTo100',
                    'rkw_checkup'
                );
            }

        }

        return '';
    }

    /**
     * moveNewResultAnswers
     * Moves answers from "newAnswers" to "answers"
     *
     * @return void
     * @throws \Exception
     */
    public function moveNewResultAnswers ()
    {
        if (!$this->result) {
            throw new \Exception('No result set.', 1638189967);
        }

        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
        foreach ($this->result->getNewResultAnswer() as $resultAnswer) {
            $this->result->addResultAnswer($resultAnswer);
            $this->result->removeNewResultAnswer($resultAnswer);
        }
    }

    /**
     * setNextStep
     *
     * @return void
     * @throws \Exception
     */
    public function setNextStep ()
    {
        if (!$this->result) {
            throw new \Exception('No result set.', 1638189967);
        }

        StepUtility::next($this->result);
    }

    /**
     * persist
     *
     * @return void
     */
    public function persist ()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \RKW\RkwCheckup\Domain\Repository\ResultRepository $resultRepository */
        $resultRepository = $objectManager->get(ResultRepository::class);
        if ($this->result->_isNew()) {
            $resultRepository->add($this->result);
        } else {
            $resultRepository->update($this->result);
        }

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager */
        $persistenceManager = $objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
    }

    /**
     * Set result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     */
    public function set (\RKW\RkwCheckup\Domain\Model\Result $result)
    {
        $this->result = $result;
    }

    /**
     * Returns result
     *
     * @return \RKW\RkwCheckup\Domain\Model\Result $result
     */
    public function get ()
    {
        return $this->result;
    }

    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    public function getLogger ()
    {
        return GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
    }

    /**
     * Returns TYPO3 settings
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings ()
    {

        if (!$this->settings) {
            $this->settings = GeneralUtility::getTyposcriptConfiguration('Rkwcheckup');
        }


        if (!$this->settings) {
            return array();
        }

        return $this->settings;
    }


}