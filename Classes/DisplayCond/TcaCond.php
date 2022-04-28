<?php
namespace RKW\RkwCheckup\DisplayCond;

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
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class TcaCond
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TcaCond
{
    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;


    /**
     * displayCondByParentType
     *
     * @param array $params
     * @return bool
     */
    public function answerDisplayCondByParentType(array $params): bool
    {
        /** @var ObjectManager $objectManager */
        //$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var QuestionRepository $questionRepository */
        //$questionRepository = $objectManager->get(QuestionRepository::class);
        
        /** @var Question $entityToStop */
        /*$question = $questionRepository->findByIdentifier(intval($params['record']['question']));
        if ($question instanceof Question) {
            // @toDo: Solution with TypoScript??
            if ($question->getRecordType() == 4) {
                return false;
            }
        }*/

        return true;
    }
    
}