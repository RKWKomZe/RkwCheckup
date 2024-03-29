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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class TcaProcFunc
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TcaProcFunc
{
    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ConfigurationManager $configurationManager;


    /**
     * Returns answerList of a check
     *
     * @param array $params
     * @return void
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     * @todo SK: this function does not have a return value and the params are not passed as reference - so what does it actually do?
     */
    public function getAnswerList(array $params): void
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
     * @return \RKW\RkwCheckup\Domain\Model\Checkup|null $checkup
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function getCheckup(array $params):? Checkup
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        // if it's a question get it's step
        $sectionUid = 0;
        if ($params['table'] == 'tx_rkwcheckup_domain_model_question') {

            /** @var StepRepository $stepRepository */
            $stepRepository = $objectManager->get(StepRepository::class);
            /** @var Step $step */
            $step = $stepRepository->findByIdentifier(intval($params['row']['step']));

            if ($step instanceof Step) {

                // get section of step (it's only passthrough)
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_rkwcheckup_domain_model_step');
                $result = $queryBuilder
                    ->select('uid', 'section')
                    ->from('tx_rkwcheckup_domain_model_step')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($step->getUid(), \PDO::PARAM_INT))
                    )
                    ->execute();
                while ($row = $result->fetch()) {
                    // Do something with that single row
                    $sectionUid = $row['section'];
                }
            }
        }

        // if it's a step, get the section and it's checkup uid
        $checkupUid = 0;
        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_step'
            || $sectionUid
        ) {
            /** @var SectionRepository $sectionRepository */
            $sectionRepository = $objectManager->get(SectionRepository::class);

            /** @var Section $section */
            $sectionUid = $sectionUid ?: intval($params['row']['section']);
            $section = $sectionRepository->findByIdentifier($sectionUid);
            // if "$section->getCheckup() instanceof Checkup" is needed for create translated records in TCA (because its not persistent yet)
            if (
                $section instanceof Section
                && $section->getCheckup() instanceof Checkup
            ) {
                $checkupUid = $section->getCheckup()->getUid();
            }
        }

        // if it's a section, get it's checkup uid directly
        $checkup = null;
        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_section'
            || $checkupUid
        ) {
            /** @var CheckupRepository $checkupRepository */
            $checkupRepository = $objectManager->get(CheckupRepository::class);

            /** @var Checkup $checkup */
            $checkupUid = $checkupUid ?: intval($params['row']['checkup']);
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
     * @return \TYPO3\CMS\Extbase\DomainObject\AbstractEntity|null $entity
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function getEntityToStop(array $params):? AbstractEntity
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

        $entityToStop = null;
        if (
            $params['table'] == 'tx_rkwcheckup_domain_model_step'
            || $stepToStopUid
        ) {
            /** @var StepRepository $stepRepository */
            $stepRepository = $objectManager->get(StepRepository::class);

            /** @var Step $entityToStop */
            $stepUid = $stepToStopUid ?: intval($params['row']['uid']);
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
    public function displayCondByParentType(array $params): bool
    {
        return true;
    }


}
