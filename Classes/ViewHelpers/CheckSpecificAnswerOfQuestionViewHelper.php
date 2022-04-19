<?php
namespace RKW\RkwCheckup\ViewHelpers;
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

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


/**
 * Class GetAnswersOfQuestionViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckSpecificAnswerOfQuestionViewHelper extends AbstractViewHelper {

    use CompileWithRenderStatic;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('resultSet', 'array', 'result set from GetAnswersOfQuestionViewHelper');
        $this->registerArgument('answer', '\RKW\RkwCheckup\Domain\Model\Answer', 'The answer to check');
    }

    /**
     * Returns array with answers of given question
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $resultSet = $arguments['resultSet'];
        /** @var \RKW\RkwCheckup\Domain\Model\Answer $answer */
        $answer = $arguments['answer'];


        /** @var \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer */
        foreach ($resultSet as $resultAnswer) {

            $isInvertedFeedback = $resultAnswer->getQuestion()->isInvertFeedback();

            if ($resultAnswer->getAnswer()->getUid() === $answer->getUid()) {
                // if inverted: Don't check answer
                $returnValue = $isInvertedFeedback ? false : true;
            } else {
                // if inverted: Check opposing answer
                $returnValue = $isInvertedFeedback ? true : false;
            }
            return $returnValue;
        }

        return false;
    }
}