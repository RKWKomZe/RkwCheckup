<?php

namespace RKW\RkwCheckup\Utility;

use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Model\StepFeedback;

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
 * Class StepUtility
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StepUtility
{
    /**
     * result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     */
    private static $result = null;

    /**
     * currentSection
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $sectionToCheck
     */
    private static $currentSection = null;

    /**
     * which step comes next? Replace step and / or section of the given result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function next ($result)
    {
        self::$result = $result;

        // get current section
        self::fastForwardToCurrentSection();

        // get current step
        self::fastForwardToCurrentStep();

        // do we have to show a step feedback?
        $showStepFeedback = self::showStepFeedback();

        if (!$showStepFeedback) {
            // set next step
            self::setNextStepToResult();

            // check if next step will show at least one question (check section, step and questions "hide"-condition)
            if(!self::showNextStep()) {
                // go ahead, if the recent set section or step should not be shown to the user
                self::next(self::$result);
            }

            // check and set flag on last step
            self::toggleLastStepFlag();
        }
    }


    /**
     * fastForwardToCurrentSection
     *
     * @return void
     */
    protected static function fastForwardToCurrentSection ()
    {
        // iterate sections
        $sectionsTotal = self::$result->getCheckup()->getSection()->count();
        for ($i = 0; $i < $sectionsTotal; $i++) {

            // object storage: Start at beginning (rewind) or fast forward (next)
            !$i ? self::$result->getCheckup()->getSection()->rewind() : self::$result->getCheckup()->getSection()->next();
            $sectionToCheck = self::$result->getCheckup()->getSection()->current();

            // check if there are more steps inside that section
            if ($sectionToCheck === self::$result->getCurrentSection()) {
                self::$currentSection = self::$result->getCurrentSection();
                break;
            }
        }
    }


    /**
     * fastForwardToCurrentStep
     *
     * @return void
     */
    protected static function fastForwardToCurrentStep ()
    {
        // iterate steps
        $stepsTotal = self::$currentSection->getStep()->count();
        for ($j = 0; $j < $stepsTotal; $j++) {

            // object storage: Start at beginning (rewind) or fast forward (next)
            !$j ? self::$currentSection->getStep()->rewind() : self::$currentSection->getStep()->next();
            $stepToCheck = self::$currentSection->getStep()->current();

            // check if there are more steps inside that section
            if ($stepToCheck === self::$result->getCurrentStep()) {
                break;
            }
        }
    }


    /**
     * showStepFeedback
     * do we have to show a step feedback before forwarding to the next step?
     *
     * @return bool
     */
    protected static function showStepFeedback ()
    {
        // is already true? Then reset the value and return false (we'll never show a feedback twice)
        if (self::$result->isShowStepFeedback()) {
            self::$result->setShowStepFeedback(false);
            return false;
        }

        // check for stepFeedback of current step
        /** @var Step $currentStep */
        $currentStep = self::$currentSection->getStep()->current();
        if ($currentStep->getStepFeedback() instanceof StepFeedback) {
            self::$result->setShowStepFeedback(true);
            return true;
        }

        return false;
    }


    /**
     * setNextStepToResult
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function setNextStepToResult (Result $result = null)
    {
        if ($result) {
            self::$result = $result;
        }

        // set next step and / or next section
        // fast forward to next step
        self::$currentSection->getStep()->next();
        if ($nextStep = self::$currentSection->getStep()->current()) {
            // either: Set next step in current section
            self::$result->setCurrentStep($nextStep);
        } else {
            // or: Set next section with it's first step
            // fast forward to next section
            self::$result->getCheckup()->getSection()->next();
            if (self::$result->getCheckup()->getSection()->current()) {
                /** @var \RKW\RkwCheckup\Domain\Model\Section $nextSection */
                $nextSection = self::$result->getCheckup()->getSection()->current();
                /** @var \RKW\RkwCheckup\Domain\Model\Step $nextStep */
                $nextSection->getStep()->rewind();
                $nextStep = $nextSection->getStep()->current();

                self::$result->setCurrentSection($nextSection);
                self::$result->setCurrentStep($nextStep);
            }
        }
    }

    /**
     * showNextStep
     * return false if the current section or step should be skipped
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return bool
     * @throws \Exception
     */
    public static function showNextStep (Result $result = null)
    {
        if ($result) {
            self::$result = $result;
        }

        // check if whole section should be skipped
        /** @var Answer $hideCondition */
        foreach (self::$result->getCurrentSection()->getHideCond() as $hideCondition) {
            foreach (self::$result->getResultAnswer() as $resultAnswer) {
                if ($resultAnswer->getAnswer() === $hideCondition) {
                    // hide condition match: hide section!
                    return false;
                }
            }
        }

        // check if step should be skipped
        /** @var Answer $hideCondition */
        foreach (self::$result->getCurrentStep()->getHideCond() as $hideCondition) {
            foreach (self::$result->getResultAnswer() as $resultAnswer) {
                if ($resultAnswer->getAnswer() === $hideCondition) {
                    // hide condition match: hide step!
                    return false;
                }
            }
        }

        // check if at least one question would shown. Otherwise also skip this step
        $atLeastOneQuestionWillShown = false;
        /** @var Question $question */
        foreach (self::$result->getCurrentStep()->getQuestion() as $question) {
            /** @var Answer $hideCondition */
            foreach ($question->getHideCond() as $hideCondition) {
                foreach (self::$result->getResultAnswer() as $resultAnswer) {
                    if ($resultAnswer->getAnswer() !== $hideCondition) {
                        // at least one question would shown at this step. Set variable to true and make a break!
                        $atLeastOneQuestionWillShown = true;
                        break;
                    }
                }
            }
        }

        if (!$atLeastOneQuestionWillShown) {
            // no question would be shown at this step. So we have to skip
            return false;
        }

        return true;
    }


    /**
     * toggleLastStepFlag
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function toggleLastStepFlag (Result $result = null)
    {
        if ($result) {
            self::$result = $result;
        }

        // @toDo: Prüfen, ob der letzte Schritt via Condition bereits ausgeschlossen ist?
        // -> Problem: Wenn wir erst im vorletzten Schritt eine Antwort wählen könnten, die den letzten Schritt ausschließen kann,
        // dann können wir hier die Flagge gar nicht setzen (und damit etwa den "weiter" Button in "Check abschließen" umbennen)
        // (wäre also eine logische Lücke: Sollte der vorletzte Step den letzten Step ausschließen)

        // check if there are is one more step
        self::$currentSection->getStep()->next();
        if (self::$currentSection->getStep()->current()) {
            // there is one more step. Do nothing.
            return;
        }

        // no more steps in current section. Does we have more sections?
        self::$result->getCheckup()->getSection()->next();
        if (!self::$result->getCheckup()->getSection()->current()) {

            // no more sections, no more steps. Set flag, that we're in the last step!
            self::$result->setLastStep(true);
            return;
        }

        self::$result->setLastStep(false);
    }

}