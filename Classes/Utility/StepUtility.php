<?php

namespace RKW\RkwCheckup\Utility;
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

use RKW\RkwCheckup\Domain\Model\AbstractCheckupContents;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Model\Feedback;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
    private static $result;

    
    /**
     * currentSection
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $sectionToCheck
     */
    private static $currentSection;

    
    /**
     * which step comes next? Replace step and / or section of the given result
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function next (Result $result): void
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
            $i = 0;
            do {
                self::setNextStepToResult();
                $i++;
                if ($i == 2) {
                    var_dump(self::$result->getCurrentStep());
                }
            } while (
                !self::showStepOfResult(self::$result)
                && (self::$result->getCurrentStep() instanceof Step)
            ) ;
        }

        // check and set flag on last step
        self::toggleLastStepFlag();
    }


    /**
     * fastForwardToCurrentSection
     *
     * @return void
     */
    protected static function fastForwardToCurrentSection (): void
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
    protected static function fastForwardToCurrentStep (): void
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
    protected static function showStepFeedback (): bool
    {
        // is already true? Then reset the value and return false (we'll never show a feedback twice)
        if (self::$result->isShowStepFeedback()) {
            self::$result->setShowStepFeedback(false);
            return false;
        }

        // check for stepFeedback of current step
        /** @var Step $currentStep */
        $currentStep = self::$currentSection->getStep()->current();
        if ($currentStep->getFeedback() instanceof Feedback) {
            self::$result->setShowStepFeedback(true);
            return true;
        }

        return false;
    }


    /**
     * setNextStepToResult
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result|null $result
     * @return void
     * @throws \Exception
     */
    protected static function setNextStepToResult (Result $result = null): void
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

            } else {
                // THE END!
                // there is no more step AND no more section
                self::$result->setCurrentSection(null);
                self::$result->setCurrentStep(null);
            }
        }

    }


    /**
     * showStepOfResult
     * return false if the current section or step should be skipped
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return bool
     * @throws \Exception
     */
    public static function showStepOfResult (Result $result): bool
    {
        // if there is no current step set, we are already at the end!
        if (!$result->getCurrentStep()) {
            return false;
        }

        return self::showStep($result->getCurrentStep(), $result->getCurrentSection(), $result);
    }



    /**
     * showStep
     * return false if the current section or step should be skipped
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @param \RKW\RkwCheckup\Domain\Model\Result|null $result
     * @return bool
     * @throws \Exception
     */
    public static function showStep (Step $step, Section $section, Result $result = null): bool
    {

        if ($result) {
            self::$result = $result;
        }

        // check if whole section should be skipped
        if (
            self::findHideCond($section)
            || !self::findVisibleCond($section)
        ) {
            // hide condition match: don't show section!
            return false;
        }

        // check if step should be skipped
        if (
            self::findHideCond($step)
            || !self::findVisibleCond($step)
        ) {
            // hide condition match: don't show step!
            return false;
        }

        // check if at least one question would shown. Otherwise also skip this step
        $atLeastOneQuestionWillShown = false;
        /** @var Question $question */
        foreach ($step->getQuestion() as $question) {

            // findHideCond returns true if entity should NOT be shown
            if (
                !self::findHideCond($question)
                || self::findVisibleCond($question)
            ) {
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
     * @param \RKW\RkwCheckup\Domain\Model\Result|null $result
     * @return void
     * @throws \Exception
     */
    public static function toggleLastStepFlag (Result $result = null): void
    {
        if ($result) {
            self::$result = $result;

            if (!self::$currentSection) {
                self::fastForwardToCurrentSection();
            }
        }

        // if we are already finished with everything, to out!
        if (
            self::$result->isLastStep()
            && ! self::$result->getCurrentStep()
            && ! self::$result->getCurrentSection()
        ) {
            // do nothing
            return;
        }

        // check if there is at least one more step
        // check all remaining steps to check if there is something to show
        do {
            /** @var Step $nextStep */
            $nextStep = self::$currentSection->getStep()->current();
            /** @var Section $nextSection */
            $nextSection = self::$result->getCheckup()->getSection()->current();

            // no next step? Forward to next section with first step
            self::$currentSection->getStep()->next();
            if (!self::$currentSection->getStep()->current()) {
                // forward one section
                self::$result->getCheckup()->getSection()->next();
                if (self::$result->getCheckup()->getSection()->current()) {
                    $nextSection = self::$result->getCheckup()->getSection()->current();
                    /** @var \RKW\RkwCheckup\Domain\Model\Step $nextStep */
                    $nextSection->getStep()->rewind();
                    $nextStep = $nextSection->getStep()->current();
                    if (self::showStep($nextStep, $nextSection)) {
                        return;
                    }
                }
            } else {

                // we want to check the following step, so forward with next()
                // WORKAROUND START: Because following line does not work here by any reason!!
                // $nextStep = self::$currentSection->getStep()->next();
                $currentStepIsPassed = false;
                foreach (self::$currentSection->getStep() as $step) {

                    if ($currentStepIsPassed) {
                        $nextStep = $step;
                        break;
                    }

                    if ($step->getUid() == $nextStep->getUid()) {
                        // current step found
                        $currentStepIsPassed = true;
                    }
                }
                // WORKAROUND END

                if (self::showStep($nextStep, $nextSection)) {
                    return;
                }
            }

        } while(
            $nextSection instanceof Section
            && $nextStep instanceof Step
        );


        // if nothing else happens until here: There is no more step!
        self::$result->setLastStep(true);
    }


    /**
     * findHideCond
     * returns true on hideCond match
     *
     * @param \RKW\RkwCheckup\Domain\Model\AbstractCheckupContents $entity
     * @return bool
     */
    protected static function findHideCond (AbstractCheckupContents $entity) : bool
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


    /**
     * findVisibleCond
     * returns true on visibleCond match
     *
     * @param \RKW\RkwCheckup\Domain\Model\AbstractCheckupContents $entity
     * @return bool
     */
    protected static function findVisibleCond (AbstractCheckupContents $entity) : bool
    {
        $showQuestion = true;
        if ($entity->getVisibleCond()->count()) {
            // if there is a visible condition: Hide!
            $showQuestion = false;
            foreach ($entity->getVisibleCond() as $visibleCondition) {
                /** @var ResultAnswer $resultAnswer */
                foreach (self::$result->getResultAnswer() as $resultAnswer) {
                    if ($resultAnswer->getAnswer() === $visibleCondition) {
                        // if there is a correct answer: Show!
                        $showQuestion = true;
                    }
                }
            }
        }

        return $showQuestion;
    }

}