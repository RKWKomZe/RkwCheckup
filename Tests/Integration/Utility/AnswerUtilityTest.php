<?php
namespace RKW\RkwCheckup\Tests\Integration\Utility;
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

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Repository\AnswerRepository;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\Utility\AnswerUtility;
use RKW\RkwCheckup\Utility\StepUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * AnswerUtilityTest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AnswerUtilityTest extends FunctionalTestCase
{
    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/AnswerUtilityTest/Fixtures';


    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/core_extended',
        'typo3conf/ext/rkw_checkup',
    ];


    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [
    ];


    /**
     * @var \RKW\RkwCheckup\Utility\StepUtility|null
     */
    private ?StepUtility $subject = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository|null
     */
    private ?CheckupRepository $checkupRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\SectionRepository|null
     */
    private ?SectionRepository $sectionRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\StepRepository|null
     */
    private ?StepRepository $stepRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\QuestionRepository|null
     */
    private ?QuestionRepository $questionRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\AnswerRepository|null
     */
    private ?AnswerRepository $answerRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository|null
     */
    private ?ResultRepository $resultRepository = null;


    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager|null
     */
    private ?ObjectManager $objectManager = null;


    /**
     * Setup
     * @throws \Exception
     */
    protected function setUp(): void
    {

        parent::setUp();
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Global.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:core_extended/Configuration/TypoScript/setup.typoscript',
                'EXT:core_extended/Configuration/TypoScript/constants.typoscript',
                'EXT:rkw_checkup/Configuration/TypoScript/setup.typoscript',
                'EXT:rkw_checkup/Configuration/TypoScript/constants.typoscript',
                self::FIXTURE_PATH . '/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(AnswerUtility::class);
        // Repository
        $this->checkupRepository = $this->objectManager->get(CheckupRepository::class);
        $this->sectionRepository = $this->objectManager->get(SectionRepository::class);
        $this->stepRepository = $this->objectManager->get(StepRepository::class);
        $this->questionRepository = $this->objectManager->get(QuestionRepository::class);
        $this->answerRepository = $this->objectManager->get(AnswerRepository::class);

        $this->resultRepository = $this->objectManager->get(ResultRepository::class);
    }

    //===================================================================

    /**
     * @test
     */
    public function fetchAllOfCheckupWithCheckupReturnsAllAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a Check
         * When the function is called
         * Then all answers of the check are returned
         * Then the answers are instanceof Answer
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var Checkup $check */
        $check = $this->checkupRepository->findByIdentifier(1);

        $result = $this->subject->fetchAllOfCheckup($check);

        self::assertCount(14, $result);
        self::assertInstanceOf('RKW\RkwCheckup\Domain\Model\Answer', $result[0]);

    }


    /**
     * @test
     */
    public function fetchAllOfCheckupWithCheckupAndFirstSectionAsStopEntityReturnsNoAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a Check
         * Given is the first Section as StopEntity
         * When the function is called
         * Then no answers of the check are returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var Checkup $check */
        $check = $this->checkupRepository->findByIdentifier(1);
        /** @var Section $stopEntity */
        $stopEntity = $this->sectionRepository->findByIdentifier(1);

        $result = $this->subject->fetchAllOfCheckup($check, $stopEntity);

        self::assertCount(0, $result);

    }


    /**
     * @test
     */
    public function fetchAllOfCheckupWithCheckupAndSecondSectionAsStopEntityReturnsNotAllAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a Check
         * Given is the second Section as StopEntity
         * When the function is called
         * Then only a part of the answers of the check are returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var Checkup $check */
        $check = $this->checkupRepository->findByIdentifier(1);
        /** @var Section $stopEntity */
        $stopEntity = $this->sectionRepository->findByIdentifier(2);

        $result = $this->subject->fetchAllOfCheckup($check, $stopEntity);

        self::assertCount(10, $result);

    }


    /**
     * @test
     */
    public function fetchAllOfCheckupWithCheckupAndFirstStepAsStopEntityReturnsNoAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a Check
         * Given is the first Step as StopEntity
         * When the function is called
         * Then no answers of the check are returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var Checkup $check */
        $check = $this->checkupRepository->findByIdentifier(1);
        /** @var Step $stopEntity */
        $stopEntity = $this->stepRepository->findByIdentifier(1);

        $result = $this->subject->fetchAllOfCheckup($check, $stopEntity);

        self::assertCount(0, $result);
    }


    /**
     * @test
     */
    public function fetchAllOfCheckupWithCheckupAndSecondStepAsStopEntityReturnsNotAllAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a Check
         * Given is the second Step as StopEntity
         * When the function is called
         * Then no answers of the check are returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var Checkup $check */
        $check = $this->checkupRepository->findByIdentifier(1);
        /** @var Step $stopEntity */
        $stopEntity = $this->stepRepository->findByIdentifier(2);

        $result = $this->subject->fetchAllOfCheckup($check, $stopEntity);

        self::assertCount(10, $result);
    }

    //===================================================================

    /**
     * TearDown
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

}
