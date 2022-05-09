<?php
namespace RKW\RkwCheckup\Tests\Integration\Utility;


use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Repository\AnswerRepository;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\Step\ProgressHandler;
use RKW\RkwCheckup\Utility\StepUtility;
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
 * StepUtilityTest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StepUtilityTest extends FunctionalTestCase
{
    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/StepUtilityTest/Fixtures';

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
     * @var \RKW\RkwCheckup\Utility\StepUtility
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

        $this->subject = $this->objectManager->get(StepUtility::class);
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
    public function nextWithShowSectionIntroRemovesThatFlag ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup which is showing section intro
         * When the function is called
         * Then the showSectionIntro flag is changed to false
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertTrue($checkResult->isShowSectionIntro());

        $this->subject->next($checkResult);

        static::assertFalse($checkResult->isShowSectionIntro());

    }


    /**
     * @test
     */
    public function nextWithShowStepFeedbackRemovesThatFlagToFalse ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup which is showing step feedback
         * When the function is called
         * Then the showStepFeedback flag is changed to false
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check110.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertTrue($checkResult->isShowStepFeedback());

        $this->subject->next($checkResult);

        static::assertFalse($checkResult->isShowStepFeedback());
    }


    /**
     * @test
     */
    public function nextWithWithStepThatHaveStepFeedbackSetThatFlagToTrue ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup which is in a step with following step feedback
         * When the function is called
         * Then the showStepFeedback flag is changed to true
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check120.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertFalse($checkResult->isShowStepFeedback());

        $this->subject->next($checkResult);

        static::assertTrue($checkResult->isShowStepFeedback());

    }


    /**
     * @test
     */
    public function nextWithWithNothingSpecialSetTheNextStepInsideCurrentSection ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup in common case
         * When the function is called
         * Then the next step is set (the section does NOT change)
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check130.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(1, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

        $this->subject->next($checkResult);

        static::assertEquals(2, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

    }


    /**
     * @test
     */
    public function nextWithWithinTheLastStepInsideSectionSetTheNextStepInsideTheNextSection ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the last step of a section
         * When the function is called
         * Then the next step is set; the next section is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check140.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(3, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

        $this->subject->next($checkResult);

        static::assertEquals(4, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(2, $checkResult->getCurrentSection()->getUid());

    }


    /**
     * @test
     */
    public function nextWithWithinTheOverallSecondLastStepSetTheLastStepWithFlag ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the overall second last step of the check
         * When the function is called
         * Then the next step is set; the next section is set; the lastStep flag is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check150.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(4, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(2, $checkResult->getCurrentSection()->getUid());
        static::assertFalse($checkResult->isLastStep());

        $this->subject->next($checkResult);

        static::assertEquals(5, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(3, $checkResult->getCurrentSection()->getUid());
        static::assertTrue($checkResult->isLastStep());

    }



    /**
     * @test
     */
    public function nextWithWithinTheLastStepDoesNothing ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the last step of the check
         * When the function is called
         * Then nothing changed
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check160.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(5, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(3, $checkResult->getCurrentSection()->getUid());
        static::assertTrue($checkResult->isLastStep());

        $this->subject->next($checkResult);

        static::assertNull($checkResult->getCurrentStep());
        static::assertNull($checkResult->getCurrentSection());
        static::assertTrue($checkResult->isLastStep());

    }


    /**
     * @test
     */
    public function nextWithWithinTheOverallThirdLastStepWithHiddenConditionOfLastStepSetTheLastStepWithFlag ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the overall third last step of the check
         * Given is a condition which means that the "real" last step does not should shown
         * Given is a second last step which is becomes the last step because of the condition
         * When the function is called
         * Then the second last step is set; also the lastStep flag is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check20.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check170.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(3, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

        $this->subject->next($checkResult);

        static::assertEquals(4, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(2, $checkResult->getCurrentSection()->getUid());
        static::assertTrue($checkResult->isLastStep());

    }


    /**
     * @test
     */
    public function nextWithWithinTheOverallSecondLastStepWithStepFeedbackDontTheLastStepWithFlag ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the overall second last step of the check
         * When the function is called
         * Then the next step is set; the next section is set; the lastStep flag is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check30.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check180.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertFalse($checkResult->isLastStep());
        static::assertFalse($checkResult->isShowStepFeedback());

        $this->subject->next($checkResult);

        static::assertFalse($checkResult->isLastStep());
        static::assertTrue($checkResult->isShowStepFeedback());

    }


    /**
     * @test
     */
    public function nextWithWithinTheOverallSecondLastStepWithVisibleConditionShowsThatStep ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the overall second last step of the check
         * Given is an Answer which is the visible condition for the next step
         * When the function is called
         * Then the next step is set and the next section is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check40.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check190.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(1, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

        $this->subject->next($checkResult);

        static::assertEquals(2, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

    }



    /**
     * @test
     */
    public function nextWithWithinTheOverallSecondLastStepWithVisibleConditionSkipThatStep ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup inside the overall second last step of the check
         * Given is NO Answer which is the visible condition for the next step
         * When the function is called
         * Then the next (and last!) step is skipped
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check40.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check180.xml');

        /** @var Result $checkResult */
        $checkResult = $this->resultRepository->findByIdentifier(1);

        static::assertEquals(1, $checkResult->getCurrentStep()->getUid());
        static::assertEquals(1, $checkResult->getCurrentSection()->getUid());

        $this->subject->next($checkResult);

        static::assertNull($checkResult->getCurrentStep());
        static::assertNull($checkResult->getCurrentSection());

    }


    //===================================================================


    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

}
