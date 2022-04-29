<?php
namespace RKW\RkwCheckup\Tests\Functional\Controller;


use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwCheckup\Controller\CommandController;
use RKW\RkwCheckup\Domain\Model\Check;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Repository\AnswerRepository;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepFeedbackRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\Step\ProgressHandler;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use RKW\RkwRegistration\Service\AuthFrontendUserService;
use RKW\RkwRegistration\Register\GroupRegister;
use RKW\RkwRegistration\DataProtection\PrivacyHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * CommandControllerTest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommandControllerTest extends FunctionalTestCase
{
    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/CommandControllerTest/Fixtures';

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
        'typo3conf/ext/rkw_checkup',
    ];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [
    ];

    /**
     * @var \RKW\RkwCheckup\Controller\CommandController
     */
    private $subject = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     */
    private $checkupRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\SectionRepository
     */
    private $sectionRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\StepRepository
     */
    private $stepRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\StepFeedbackRepository
     */
    private $stepFeedbackRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\QuestionRepository
     */
    private $questionRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\AnswerRepository
     */
    private $answerRepository = null;

    /**
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     */
    private $resultRepository = null;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private $objectManager = null;

    /**
     * Setup
     * @throws \Exception
     */
    protected function setUp()
    {

        parent::setUp();
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Global.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_basics/Configuration/TypoScript/setup.typoscript',
                'EXT:rkw_basics/Configuration/TypoScript/constants.typoscript',
                'EXT:rkw_checkup/Configuration/TypoScript/setup.typoscript',
                'EXT:rkw_checkup/Configuration/TypoScript/constants.typoscript',
                self::FIXTURE_PATH . '/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(CommandController::class);
        // Repository
        $this->checkupRepository = $this->objectManager->get(CheckupRepository::class);
        $this->sectionRepository = $this->objectManager->get(SectionRepository::class);
        $this->stepRepository = $this->objectManager->get(StepRepository::class);
        $this->stepFeedbackRepository = $this->objectManager->get(StepFeedbackRepository::class);
        $this->questionRepository = $this->objectManager->get(QuestionRepository::class);
        $this->answerRepository = $this->objectManager->get(AnswerRepository::class);

        $this->resultRepository = $this->objectManager->get(ResultRepository::class);
    }

    //===================================================================

    /**
     * @test
     */
    public function cleanupDeletedCommandWithNoDeletedCheckDeletedNothing ()
    {
        /**
         * Scenario:
         *
         * Given is a NOT deleted Checkup
         * When the function is called
         * Then nothing is deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        $checkup = $this->checkupRepository->findByIdentifier(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);

        $this->subject->cleanupDeletedCommand(0);

        // All data still exists. Nothing is removed!
        $checkup = $this->checkupRepository->findByIdentifier(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
        $section = $this->sectionRepository->findByUid(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Section', $section);
        $step = $this->stepRepository->findByUid(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Step', $step);
        $question = $this->questionRepository->findByUid(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Question', $question);
        $answer = $this->answerRepository->findByUid(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Answer', $answer);
    }


    /**
     * @test
     */
    public function cleanupDeletedCommandWithHiddenCheckDeletedNothing ()
    {
        /**
         * Scenario:
         *
         * Given is a HIDDEN Checkup
         * When the function is called
         * Then nothing is deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check30.xml');

        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);

        $this->subject->cleanupDeletedCommand(0);

        // All data still exists. Nothing is removed!
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
    }


    /**
     * @test
     */
    public function cleanupDeletedCommandWithDeletedCheckDeletedIt ()
    {
        /**
         * Scenario:
         *
         * Given is a deleted Checkup
         * When the function is called
         * Then everything is related to that checkup is deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check20.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
        $section = $this->sectionRepository->findAll();
        static::assertCount(1, $section);
        $step = $this->stepRepository->findAll();
        static::assertCount(2, $step);
        $stepFeedback = $this->stepFeedbackRepository->findAll();
        static::assertCount(1, $stepFeedback);
        $question = $this->questionRepository->findAll();
        static::assertCount(3, $question);
        $answer = $this->answerRepository->findAll();
        static::assertCount(10, $answer);

        $this->subject->cleanupDeletedCommand(0);

        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
        $persistenceManager->clearState();

        // everything is removed!
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertNotInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
        $section = $this->sectionRepository->findAll();
        static::assertCount(0, $section);
        $step = $this->stepRepository->findAll();
        static::assertCount(0, $step);
        $stepFeedback = $this->stepFeedbackRepository->findAll();
        static::assertCount(0, $stepFeedback);
        $question = $this->questionRepository->findAll();
        static::assertCount(0, $question);
        $answer = $this->answerRepository->findAll();
        static::assertCount(0, $answer);
    }


    /**
     * @test
     */
    public function cleanupDeletedCommandWithDeletedCheckInsideTimeFrameDeletedNothing ()
    {
        /**
         * Scenario:
         *
         * Given is a deleted Checkup
         * Given is a cronjob timeframe which is greater than the deleted checkup tstamp (last edit)
         * When the function is called
         * Then nothing is deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check20.xml');

        /** @var Checkup $checkup */
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);

        // set new timestamp
        $checkup->setTstamp(time());
        $this->checkupRepository->update($checkup);

        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
        $persistenceManager->clearState();

        $this->subject->cleanupDeletedCommand(30);

        // All data still exists. Nothing is removed!
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
    }


    /**
     * @test
     */
    public function cleanupDeletedCommandWithDeletedCheckOutsideTimeFrameGetsDeleted ()
    {
        /**
         * Scenario:
         *
         * Given is a deleted Checkup
         * Given is a cronjob timeframe which is smaller than the deleted checkup tstamp (last edit)
         * When the function is called
         * Then the check is deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check20.xml');

        /** @var Checkup $checkup */
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);

        $this->subject->cleanupDeletedCommand(30);

        // All data still exists. Nothing is removed!
        $checkup = $this->checkupRepository->findByUidAlsoDeleted(1);
        static::assertNotInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $checkup);
    }

    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

}
