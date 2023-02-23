<?php
namespace RKW\RkwCheckup\ViewHelpers\Backend;
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

use Madj2k\CoreExtended\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Repository\ResultAnswerRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class CountResultAnswerViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CountResultAnswerViewHelper extends AbstractViewHelper {


    use CompileWithRenderStatic;


    /**
     * Initialize arguments.
     *
     * @return void
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('answer', Answer::class, 'The answer to count');
        $this->registerArgument('question', Question::class, 'The question to count');
    }

    /**
     * Returns array with answers of given question
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return int
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): int {

        $answer = $arguments['answer'];
        $question = $arguments['question'];
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultAnswerRepository $resultAnswerRepository */
        $resultAnswerRepository = $objectManager->get(ResultAnswerRepository::class);

        $result = 0;
        if ($answer instanceof Answer) {
            // count given answers by answer
            $result = $resultAnswerRepository->findByAnswer($answer)->count();
        } elseif ($question instanceof Question) {
            // count given answers by question
            $result = $resultAnswerRepository->findByQuestion($question)->count();
        }

        return $result;
    }
}
