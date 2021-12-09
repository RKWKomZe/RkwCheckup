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

use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\Utility\AnswerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class TcaProcFunc
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TcaProcFunc
{
    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * Returns answerList of a check
     *
     * @param array $params
     * @return void
     */
    public function getAnswerList($params)
    {
        $checkup = $this->getCheckup($params);

        $entityToStop = $this->getEntityToStop($params);

        if ($checkup instanceof Checkup) {
            $params['items'] = AnswerUtility::fetchAllOfCheckup($checkup, $entityToStop, true);
        }
    }


    /**
     * getCheckup
     *
     * @param array $params
     * @return Checkup $checkup
     */
    private function getCheckup($params)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        // if it's a question get it's step
        $stepUid = 0;
        if ($params['table'] == 'tx_rkwcheckup_domain_model_question') {
            /** @var StepRepository $stepRepository */
            $stepRepository = $objectManager->get(StepRepository::class);
            /** @var Step $step */
            $step = $stepRepository->findByIdentifier(intval($params['row']['step']));
            if ($step instanceof Step) {
                $stepUid = $step->getUid();
            }
        }

        // if it's a step, get the section and it's checkup uid
        $checkupUid = 0;
        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_step'
            || $stepUid
        ) {
            /** @var SectionRepository $sectionRepository */
            $sectionRepository = $objectManager->get(SectionRepository::class);
            /** @var Section $section */
            $sectionUid = $stepUid ? $stepUid : intval($params['row']['section']);
            $section = $sectionRepository->findByIdentifier($sectionUid);
            if ($section instanceof Section) {
                $checkupUid = $section->getCheckup()->getUid();
            }
        }

        // if it's a section, get it's checkup uid directly
        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_section'
            || $checkupUid
        ) {
            /** @var CheckupRepository $checkupRepository */
            $checkupRepository = $objectManager->get(CheckupRepository::class);
            /** @var Checkup $checkup */
            $checkupUid = $checkupUid ? $checkupUid : intval($params['row']['checkup']);
            $checkup = $checkupRepository->findByIdentifier($checkupUid);
        }

        return $checkup;
    }


    /**
     * getEntityToStop
     * If an answer is selectable depends on the fact, if the answer can be answered before the current section, step or question is shown
     * -> by this reason we stop to show further answers at the section or step which is currently shown
     *
     * @param array $params
     * @return \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $entity
     */
    private function getEntityToStop($params)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        // Hint: Smallest unit is a "step", because two questions can be shown on one step (so the one cannot depends on the other)
        // -> because of this a question entity cannot used as a "stopEntity"
        $stepToStopUid = 0;
        if ($params['table'] == 'tx_rkwcheckup_domain_model_question') {
            /** @var QuestionRepository $questionRepository */
            $questionRepository = $objectManager->get(QuestionRepository::class);
            /** @var Question $entityToStop */
            $question = $questionRepository->findByIdentifier(intval($params['row']['uid']));
            if ($question instanceof Question) {
                $stepToStopUid = $question->getStep()->getUid();
            }
        }

        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_step'
            || $stepToStopUid
        ) {
            /** @var StepRepository $stepRepository */
            $stepRepository = $objectManager->get(StepRepository::class);
            /** @var Step $entityToStop */
            $stepUid = $stepToStopUid ? $stepToStopUid : intval($params['row']['uid']);
            $entityToStop = $stepRepository->findByIdentifier($stepUid);
        }

        if ($params['table'] == 'tx_rkwcheckup_domain_model_section') {
            /** @var SectionRepository $sectionRepository */
            $sectionRepository = $objectManager->get(SectionRepository::class);
            /** @var Section $entityToStop */
            $entityToStop = $sectionRepository->findByIdentifier(intval($params['row']['uid']));
        }

        return $entityToStop;
    }



    /**
     * displayCondByParentType
     *
     * @param array $params
     * @return bool
     */
    public function displayCondByParentType($params)
    {
        DebuggerUtility::var_dump($params); exit;
    }


}