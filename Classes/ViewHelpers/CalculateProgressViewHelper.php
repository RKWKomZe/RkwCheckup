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
use RKW\RkwCheckup\Domain\Model\Section;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;


/**
 * Class CalculateProgressViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculateProgressViewHelper extends AbstractViewHelper {


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
    ){
        /** @var \RKW\RkwCheckup\Domain\Model\Result $result */
        $result = $arguments['result'];

        $stepsTotal = 0;
        /** @var Section $section */
        foreach ($result->getCheckup()->getSection() as $section) {
            $stepsTotal += $section->getStep()->count();
        }

        $currentStepNumber = 0;
        $stopParentLoop = false;
        foreach ($result->getCheckup()->getSection() as $section) {
            foreach ($section->getStep() as $step) {
                if ($step === $result->getCurrentStep()) {
                    $stopParentLoop = true;
                    break;
                }
                $currentStepNumber++;
            }
            if ($stopParentLoop) {
                break;
            }
        }

        return round(($currentStepNumber / $stepsTotal) * 100, 0, PHP_ROUND_HALF_UP);
    }
}