<?php

namespace RKW\RkwCheckup\Utility;

use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Model\StepFeedback;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
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

        // if the current step are showing the section intro, just set it to false and show the current step
        if (self::$result->isShowSectionIntro()) {
            self::$result->setShowSectionIntro(false);
            return;
        }

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
            /*
            if (!self::showNextStep()) {
                // go ahead, if the recent set section or step should not be shown to the user

                // @toDo: PROBLEM IF THERE ARE IS NO MORE STEP!!

                //self::next(self::$result);
            }
            */

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

            // found current section?
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

            // found current step?
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
    protected static function setNextStepToResult (Result $result = null)
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

                self::$result->setShowSectionIntro(true);
            }
        }
    }

    /**
     * showNextStep
     * return false if the current section or step should be skipped
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @return bool
     * @throws \Exception
     */
    protected static function showNextStep (Step $step, Section $section)
    {

        // check if whole section should be skipped
        if (self::checkHideCond($section)) {
            // hide condition match: don't show section!
            return false;
        }

        // check if step should be skipped
        if (self::checkHideCond($step)) {
            // hide condition match: don't show step!
            return false;
        }

        // check if at least one question would shown. Otherwise also skip this step
        $atLeastOneQuestionWillShown = false;
        /** @var Question $question */
        foreach ($step->getQuestion() as $question) {

            if (self::checkHideCond($question)) {
                $atLeastOneQuestionWillShown = true;
                break;
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

            if (!self::$currentSection) {
                self::fastForwardToCurrentSection();
            }
        }

        // check if there is at least one more step
        // check all remaining steps to check if there is something to show
        do {
            /** @var Step $nextStep */
            $nextStep = self::$currentSection->getStep()->current();
            /** @var Section $nextSection */
            $nextSection = self::$result->getCheckup()->getSection()->current();

            // no next step? Forward to next section with first step
            if (!self::$currentSection->getStep()->next()) {
                // forward one section
                self::$result->getCheckup()->getSection()->next();
                if (self::$result->getCheckup()->getSection()->current()) {
                    $nextSection = self::$result->getCheckup()->getSection()->current();
                    /** @var \RKW\RkwCheckup\Domain\Model\Step $nextStep */
                    $nextSection->getStep()->rewind();
                    $nextStep = $nextSection->getStep()->current();
                }
            } else {
                $nextStep = self::$currentSection->getStep()->next();
            }

            if (
                $nextSection instanceof Section
                && $nextStep instanceof Step
                && self::showNextStep($nextStep, $nextSection)
            ) {
                // there is at least one step. Do nothing else
                return;
            }

        } while(
            $nextSection instanceof Section
            && $nextStep instanceof Step
        );

        // if nothing else happens until here: There is no more step!
        self::$result->setLastStep(true);
    }


    /**
     * checkHideCond
     * returns true on hideCond match
     *
     * @param Question|Step|Section $entity
     *
     * @return bool
     */
    protected static function checkHideCond ($entity) : bool
    {
        foreach ($entity->getHideCond() as $hideCondition) {
            foreach (self::$result->getResultAnswer() as $resultAnswer) {
                if ($resultAnswer->getAnswer() === $hideCondition) {
                    return true;
                }
            }
        }
        return false;
    }

}