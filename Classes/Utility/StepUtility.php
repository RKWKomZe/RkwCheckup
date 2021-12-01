<?php

namespace RKW\RkwCheckup\Utility;

use RKW\RkwCheckup\Domain\Model\Result;

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

        // set next step
        self::setNextStepToResult();

        // check and set flag on last step
        self::toggleLastStepFlag();
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
     * setNextStepToResult
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function setNextStepToResult (Result $result = null)
    {
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
     * toggleLastStepFlag
     *
     * @param \RKW\RkwCheckup\Domain\Model\Result $result
     * @return void
     * @throws \Exception
     */
    public static function toggleLastStepFlag (Result $result = null)
    {
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