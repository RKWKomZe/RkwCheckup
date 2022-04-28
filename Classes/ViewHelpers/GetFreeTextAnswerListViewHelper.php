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

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Repository\ResultAnswerRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


/**
 * Class GetFreeTextAnswerListViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GetFreeTextAnswerListViewHelper extends AbstractViewHelper {


    use CompileWithRenderStatic;

    
    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('question', Question::class, 'The question to get the freeTextAnswers', true);
        $this->registerArgument('count', 'bool', 'Return only count');
    }

    /**
     * Returns array with answers of given question
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return int|array|QueryResult|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public static function renderStatic(
        array $arguments, 
        \Closure $renderChildrenClosure, 
        RenderingContextInterface $renderingContext
    ){
        /** @var Question $question */
        $question = $arguments['question'];
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultAnswerRepository $resultAnswerRepository */
        $resultAnswerRepository = $objectManager->get(ResultAnswerRepository::class);

        if ($arguments['count']) {
            return $resultAnswerRepository->findFreeTextInputAnswersByQuestion($question)->count();
        } else {
            return $resultAnswerRepository->findFreeTextInputAnswersByQuestion($question);
        }

    }
}