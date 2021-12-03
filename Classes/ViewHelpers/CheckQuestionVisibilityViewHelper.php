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

use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


/**
 * Class CheckQuestionVisibilityViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckQuestionVisibilityViewHelper extends AbstractViewHelper {

    use CompileWithRenderStatic;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('result', '\RKW\RkwCheckup\Domain\Model\Result', 'The result which contains answers');
        $this->registerArgument('question', '\RKW\RkwCheckup\Domain\Model\Question', 'The question to check', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        /** @var \RKW\RkwCheckup\Domain\Model\Result $result */
        $result = $arguments['result'];
        /** @var \RKW\RkwCheckup\Domain\Model\Question $question */
        $question = $arguments['question'];

        /** @var ResultAnswer $hideCondition */
        foreach ($question->getHideCond() as $hideCondition) {
            /** @var ResultAnswer $resultAnswer */
            foreach ($result->getResultAnswer() as $resultAnswer) {
                if ($resultAnswer->getAnswer() === $hideCondition) {
                    // hide condition match: hide question!
                    return false;
                }
            }
        }

        return true;
    }
}