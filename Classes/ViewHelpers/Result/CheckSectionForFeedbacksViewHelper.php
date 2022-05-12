<?php
namespace RKW\RkwCheckup\ViewHelpers\Result;
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

use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class CheckSectionForFeedbacksViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckSectionForFeedbacksViewHelper extends AbstractViewHelper {

    
    use CompileWithRenderStatic;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('result', Result::class, 'The result which contains answers', true);
        $this->registerArgument('section', Section::class, 'The step to check', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(
        array $arguments, 
        \Closure $renderChildrenClosure, 
        RenderingContextInterface $renderingContext
    ){
        
        /** @var \RKW\RkwCheckup\Domain\Model\Result $result */
        $result = $arguments['result'];
        /** @var \RKW\RkwCheckup\Domain\Model\Section $section */
        $section = $arguments['section'];

        
        // Check if one of the questions of the step has a feedback
        /** @var \RKW\RkwCheckup\Domain\Model\Step $step */
        foreach ($section->getStep() as $step) {

            /** @var \RKW\RkwCheckup\Domain\Model\Question $question */
            foreach ($step->getQuestion() as $question) {
                if ($question->getFeedback()) {
                    return true;
                }

                // check if one of the NOT selected answers of the step has a feedback
                if ($question->getInvertFeedback()) {
                    /** @var \RKW\RkwCheckup\Domain\Model\Answer $answer */
                    foreach ($question->getAnswer() as $answer) {
                        if (!$result->getResultAnswer()->contains($answer)) {
                            if ($answer->getFeedback()) {
                                return true;
                            }
                        }
                    }

                // check if one of the selected answers has a feedback
                } else {
                    /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
                    foreach ($result->getResultAnswer() as $resultAnswer) {
                        if ($resultAnswer->getQuestion() === $question) {
                            if ($resultAnswer->getAnswer()->getFeedback()) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        
        return false;
    }
}