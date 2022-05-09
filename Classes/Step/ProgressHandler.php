<?php

namespace RKW\RkwCheckup\Step;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Exception;
use RKW\RkwCheckup\Utility\StepUtility;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
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
 * Class ProgressHandler
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ProgressHandler
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
     * @throws \Exception
     */
    public function newResult (Checkup $checkup)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->result = $objectManager->get(Result::class);
        $this->result->setCheckup($checkup);

        // unique ID with timestamp as prefix
        $this->result->setHash(uniqid(time()));

        // initial: Set first section & first step
        $this->result->setCurrentSection($checkup->getSection()->current());
        $this->result->setCurrentStep($checkup->getSection()->current()->getStep()->current());

        // set showSectionIntro to true
        $this->result->setShowSectionIntro(true);

        // IF A CHECK HAS ONLY ONE STEP
        StepUtility::toggleLastStepFlag($this->result);
    }

    
    /**
     * validateQuestion
     * Hint: Works with "getNewResultAnswer" (NOT with the persistent "getResultAnswer")
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return string Returns error message if something is wrong
     * @throws \Exception
     */
    public function validateQuestion (Question $question): string
    {
        if (!$this->result) {
            throw new Exception('No result set.', 1638189967);
        }

        // 1. Assign answers to given question
        $assignedAnswerList = [];
        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer */
        foreach ($this->result->getNewResultAnswer() as $newResultAnswer) {

            if ($question === $newResultAnswer->getQuestion()) {
                $assignedAnswerList[] = $newResultAnswer;
            }
        }

        // 2. Check it
        // 2.1 Mandatory
        if (
            ($question->getRecordType() == 1 || $question->getRecordType() == 2)
            && $question->isMandatory()
            && empty($assignedAnswerList)
        ) {
            // mandatory!
            return LocalizationUtility::translate(
                'progressHandler.error.mandatory',
                'rkw_checkup'
            );
        }

        // 2.2 Minimum
        if (
            $question->getRecordType() == 3
            && $question->getMinCheck() != 0
            && $question->getMinCheck() > count($assignedAnswerList)
        ) {
            // not enough selected!
            return LocalizationUtility::translate(
                'progressHandler.error.min',
                'rkw_checkup',
                [$question->getMinCheck()]
            );
        }

        // 2.3 Maximum
        if (
            $question->getRecordType() == 3
            && $question->getMaxCheck() != 0
            && $question->getMaxCheck() < count($assignedAnswerList)
        ) {
            // too much selected!
            return LocalizationUtility::translate(
                'progressHandler.error.max',
                'rkw_checkup',
                [$question->getMaxCheck()]
            );
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
    public function moveNewResultAnswers (): void
    {
        if (!$this->result) {
            throw new Exception('No result set.', 1638189967);
        }

        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
        // Hint for fix: By any reason the "->toArray()" function resolves the problem, that some answers are not transferred
        foreach ($this->result->getNewResultAnswer()->toArray() as $resultAnswer) {
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
    public function setNextStep (): void
    {
        if (!$this->result) {
            throw new Exception('No result set.', 1638189967);
        }

        do {
            StepUtility::next($this->result);
        } while (
            !$this->result->isLastStep()
            && !StepUtility::showStepOfResult($this->result)
        );

    }


    /**
     * progressValidation
     * for secure: Check if the "step of the answer" are identical with "current step" which is set in the result object
     * (someone could step back via browser and send answers again. In this case the answer-step and the result-step
     * would be different)
     *
     * @return bool returns true, if the results are related to the current step
     * @throws Exception
     */
    public function progressValidation (): bool
    {
        // for secure: Check if the step of the answer are identical with current step which is set in the result object
        // (someone could step back via browser and send answers again. In this case the answer-step and the result-step
        // would be different)
        if (!$this->result) {
            throw new Exception('No result set.', 1638189967);
        }

        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
        foreach ($this->result->getNewResultAnswer() as $resultAnswer) {
            if ($resultAnswer->getStep() !== $this->result->getCurrentStep()) {
                // do absolutely nothing (if this condition failed once, because the whole request then is garbage)
               return false;
            }
        }

        return true;
    }


    /**
     * persist
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function persist (): void
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
    public function setResult (\RKW\RkwCheckup\Domain\Model\Result $result): void
    {
        $this->result = $result;
    }
    

    /**
     * Returns result
     *
     * @return \RKW\RkwCheckup\Domain\Model\Result|null $result
     */
    public function getResult ()
    {
        return $this->result;
    }

    
    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    public function getLogger (): Logger
    {
        return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    
    /**
     * Returns TYPO3 settings
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings (): array
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