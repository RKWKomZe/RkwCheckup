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

use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class AnswerUtility
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AnswerUtility
{

    /**
     * fetchAllOfCheckup
     * - returns all possible answers of a check
     * - used in UserFunc for condition handling
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @param AbstractEntity|null $stopEntity The section, step or question to stop adding more to list
     * @param bool $asArrayForTca Return answers as small data array if true. Otherwise as objects
     * @return array
     */
    public static function fetchAllOfCheckup (
        Checkup $checkup, 
        AbstractEntity $stopEntity = null, 
        bool $asArrayForTca = false
    ): array {
        
        $answerListOfCheckup = [];
        $stopSearching = false;
        /** @var Section $section */
        foreach ($checkup->getSection() as $section) {

            // if stop entity is set and instanceof section, stop if given section is reached
            if (
                $stopEntity instanceof Section
                && $section === $stopEntity
                && !$stopSearching
            ) {
                $stopSearching = true;
                break;
            }

            /** @var Step $step */
            foreach ($section->getStep() as $step) {

                // if stop entity is set and instanceof step, stop if given step is reached
                if (
                    $stopEntity instanceof Step
                    && $step === $stopEntity
                    && !$stopSearching
                ) {
                    $stopSearching = true;
                    break;
                }

                // add all answers of a question to the answer array
                if (!$stopSearching) {
                    /** @var Question $question */
                    foreach ($step->getQuestion() as $question) {
                        /** @var \RKW\RkwCheckup\Domain\Model\Answer $answer */
                        foreach ($question->getAnswer() as $answer) {
                            if ($asArrayForTca) {
                                // for TCA
                                $answerListOfCheckup[] = [$step->getTitle() . ' - ' . $answer->getTitle(), $answer->getUid()];
                            } else {
                                // as object
                                $answerListOfCheckup[] = $answer;
                            }
                        }
                    }
                }
            }
        }

        return $answerListOfCheckup;
    }

}