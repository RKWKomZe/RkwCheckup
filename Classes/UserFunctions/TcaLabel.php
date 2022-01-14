<?php
namespace RKW\RkwCheckup\UserFunctions;

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

use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Repository\QuestionContainerRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class TcaLabel
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TcaLabel
{

    /**
     * Returns a label based on the given child
     *
     * @param array $params
     * @return void
     */
    public function createQuestionContainerLabel(&$params)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var QuestionRepository $questionRepository */
        $questionRepository = $objectManager->get(QuestionRepository::class);
        $question = $questionRepository->findOneByQuestionContainer(intval($params['row']['uid']));

        // Hint: Inside that UserFunc the "LocalizationUtility" is using FE locallang. NOT the locallang_db!
        if ($question instanceof Question) {
            // @toDo: Locallang
            $params['title'] = 'Container: ' . $question->getTitle() . ' --- ' . LocalizationUtility::translate('tx_rkwcheckup_domain_model_questioncontainer.type.I.' . $question->getType(), 'rkw_checkup');
        }
    }


}