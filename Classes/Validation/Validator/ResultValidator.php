<?php

namespace RKW\RkwCheckup\Validation\Validator;

use RKW\RkwCheckup\Service\ResultService;
use RKW\RkwCheckup\Utility\CheckupUtility;
use RKW\RkwEvents\Utility\DivUtility;
use \RKW\RkwBasics\Helper\Common;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
 * Class ResultValidator
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * TypoScript Settings
     *
     * @var array
     */
    protected $settings = null;

    /**
     * validation
     *
     * @var \RKW\RkwCheckup\Domain\Model\Result $newResult
     * @return boolean
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function isValid($newResult)
    {
        $isValid = true;

        // do not validate a stepFeedback
        if ($newResult->isShowStepFeedback()) {
            return $isValid;
        }

        // get current questions
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \RKW\RkwCheckup\Service\ResultService $resultService */
        $resultService = $objectManager->get(ResultService::class);
        $resultService->set($newResult);

        /** @var \RKW\RkwCheckup\Domain\Model\Question $question */
        foreach ($newResult->getCurrentStep()->getQuestion() as $question) {

            if ($validationResult = $resultService->validateQuestion($question)) {

                // do not add error message to specific answer (makes no deeper sense!)
                $this->result->forProperty('question' . $question->getUid())->addError(
                    new \TYPO3\CMS\Extbase\Error\Error(
                        $validationResult,
                        1638191288
                    )
                );
                $isValid = false;
            }
        }

        return $isValid;
    }

}

