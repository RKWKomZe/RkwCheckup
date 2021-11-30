<?php

namespace RKW\RkwCheckup\Service;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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

        // 1. Assign answers to
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
            $question->getType() == 1
            && $question->isMandatory()
            && empty($assignedAnswerList)
        ) {
            // @toDo: MANDATORY!
            return "Pflichtfeld!";
        }

        // 2.2 Minimum
        if (
            $question->getType() == 2
            && $question->getMinCheck() != 0
            && $question->getMinCheck() > count($assignedAnswerList)
        ) {
            // @toDo: Not enough selected!
            return "Sie müssen mindestens X auswählen!";
        }

        // 2.3 Maximum
        if (
            $question->getType() == 2
            && $question->getMaxCheck() != 0
            && $question->getMaxCheck() < count($assignedAnswerList)
        ) {
            // @toDo: Too much selected!
            return "Sie dürfen maximal X auswählen!";
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
     * replace next step and or section
     *
     * @return void
     * @throws \Exception
     */
    public function setNextStep ()
    {
        if (!$this->result) {
            throw new \Exception('No result set.', 1638189967);
        }

        // 1. iterate sections
        $sectionsTotal = $this->result->getCheckup()->getSection()->count();
        for ($i = 0; $i < $sectionsTotal; $i++) {

            // object storage: Start at beginning (rewind) or fast forward (next)
            !$i ? $this->result->getCheckup()->getSection()->rewind() : $this->result->getCheckup()->getSection()->next();
            $sectionToCheck = $this->result->getCheckup()->getSection()->current();

            // check if there are more steps inside that section
            if ($sectionToCheck === $this->result->getCurrentSection()) {

                // 2. iterate steps
                $stepsTotal = $sectionToCheck->getStep()->count();
                for ($j = 0; $j < $stepsTotal; $j++) {

                    // object storage: Start at beginning (rewind) or fast forward (next)
                    !$j ? $sectionToCheck->getStep()->rewind() : $sectionToCheck->getStep()->next();
                    $stepToCheck = $sectionToCheck->getStep()->current();

                    // check if there are more steps inside that section
                    if ($stepToCheck === $this->result->getCurrentStep()) {

                        // 3. set next step and / or next section
                        $sectionToCheck->getStep()->next();
                        if ($nextStep = $sectionToCheck->getStep()->current()) {
                            // either: Set next step in current section
                            $this->result->setCurrentStep($nextStep);
                            break;
                        } else {
                            // or: Set next section with it's first step
                            $this->result->getCheckup()->getSection()->next();
                            if ($this->result->getCheckup()->getSection()->current()) {
                                /** @var \RKW\RkwCheckup\Domain\Model\Section $nextSection */
                                $nextSection = $this->result->getCheckup()->getSection()->current();
                                /** @var \RKW\RkwCheckup\Domain\Model\Step $nextStep */
                                $nextSection->getStep()->rewind();
                                $nextStep = $nextSection->getStep()->current();

                                $this->result->setCurrentSection($nextSection);
                                $this->result->setCurrentStep($nextStep);

                                // @toDo: check and set if this is the last step?!

                                break;
                            } else {
                                // @toDo: End of the road: No more sections, no more steps
                                // (should be handled out of here)
                                throw new \Exception('No more steps available.', 1638279206);
                            }
                        }
                    }
                }
            }

        }


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