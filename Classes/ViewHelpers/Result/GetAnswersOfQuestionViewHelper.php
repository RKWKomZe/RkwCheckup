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

use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


/**
 * Class GetAnswersOfQuestionViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GetAnswersOfQuestionViewHelper extends AbstractViewHelper {

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
        $this->registerArgument('question', Question::class, 'The question to check', true);
    }

    /**
     * Returns array with answers of given question
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return array
     */
    public static function renderStatic(
        array $arguments, 
        \Closure $renderChildrenClosure, 
        RenderingContextInterface $renderingContext
    ){
        /** @var \RKW\RkwCheckup\Domain\Model\Result $result */
        $result = $arguments['result'];
        /** @var \RKW\RkwCheckup\Domain\Model\Question $question */
        $question = $arguments['question'];

        $answerArray = [];
        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
        foreach ($result->getResultAnswer() as $resultAnswer) {
            if ($resultAnswer->getQuestion() === $question) {
                if ($resultAnswer->getAnswer() instanceof Answer) {
                    $answerArray[$resultAnswer->getAnswer()->getUid()] = $resultAnswer;
                } else {
                    $answerArray[rand(1,9999)] = $resultAnswer;
                }
            }
        }

        // if inverted feedback is selected: Invert answers of $answerArray
        $invertAnswerArray = [];
        if ($question->isInvertFeedback()) {
            /** @var Answer $answer */
            foreach ($question->getAnswer() as $answer) {
                if (!array_key_exists($answer->getUid(), $answerArray)) {
                    // Hint: ResultAnswer is needed for selecting formFields in CheckSpecificAnswerOfQuestionViewHelper
                    $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
                    /** @var ResultAnswer $resultAnswer */
                    $resultAnswer = $objectManager->get(ResultAnswer::class);
                    $resultAnswer->setAnswer($answer);
                    $resultAnswer->setQuestion($question);
                    $invertAnswerArray[] = $resultAnswer;
                }
            }
        }

        return $question->isInvertFeedback() ? $invertAnswerArray : $answerArray;
    }
}