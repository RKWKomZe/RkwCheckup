<?php
namespace RKW\RkwCheckup\Tests\Functional\UserFunctions;

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
use RKW\RkwCheckup\Domain\Repository\AnswerRepository;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\UserFunctions\TcaProcFunc;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * TcaProcFuncTest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TcaProcFuncTest extends FunctionalTestCase
{
    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/TcaProcFuncTest/Fixtures';


    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/ajax_api',
        'typo3conf/ext/core_extended',
        'typo3conf/ext/rkw_checkup',
    ];


    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [
    ];


    /**
     * @var \RKW\RkwCheckup\UserFunctions\TcaProcFunc|null
     */
    private ?TcaProcFunc $subject = null;


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
        $this->subject = $this->objectManager->get(TcaProcFunc::class);

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
    public function getCheckupWithGivenSectionReturnsCheckup ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup
         * Given is a TCA array request with \Section
         * When the function is called
         * Then the checkup is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Section-Entity with UID 1; according to the checkup with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_section',
            'row' => [
                'uid' => 1,
                'checkup' => 1
            ]
        ];

        $result = $this->subject->getCheckup($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $result);
    }


    /**
     * @test
     */
    public function getCheckupWithGivenStepReturnsCheckup ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup
         * Given is a TCA array request with \Step
         * When the function is called
         * Then the checkup is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Step-Entity with UID 1; according to the section with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_step',
            'row' => [
                'uid' => 1,
                'section' => 1
            ]
        ];

        $result = $this->subject->getCheckup($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $result);
    }


    /**
     * @test
     */
    public function getCheckupWithGivenQuestionReturnsCheckup ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup
         * Given is a TCA array request with \Question
         * When the function is called
         * Then the checkup is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Question-Entity with UID 1; according to the step with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_question',
            'row' => [
                'uid' => 1,
                'step' => 1
            ]
        ];

        $result = $this->subject->getCheckup($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $result);
    }


    /**
     * @test
     */
    public function getCheckupWithGivenAndHiddenSectionReturnsCheckup ()
    {
        /**
         * Scenario:
         *
         * -> Maybe not realistic this testcase.
         *
         * Given is a Checkup
         * Given is a TCA array request with \Section (is hidden!)
         * When the function is called
         * Then the checkup is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the hiddenSection-Entity with UID 2; according to the checkup with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_section',
            'row' => [
                'uid' => 2,
                'checkup' => 1
            ]
        ];

        $result = $this->subject->getCheckup($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $result);
    }

    //===================================================================

    /**
     * @test
     */
    public function getEntityToStopWithSectionReturnsSection ()
    {
        /**
         * Scenario:
         *
         * Given is a Section
         * Given is a TCA array request with \Section
         * When the function is called
         * Then the section is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Section-Entity with UID 1; according to the checkup with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_section',
            'row' => [
                'uid' => 1,
            ]
        ];

        $result = $this->subject->getEntityToStop($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Section', $result);
    }


    /**
     * @test
     */
    public function getEntityToStopWithStepReturnsStep ()
    {
        /**
         * Scenario:
         *
         * Given is a Step
         * Given is a TCA array request with \Step
         * When the function is called
         * Then the step is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Section-Entity with UID 1; according to the checkup with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_step',
            'row' => [
                'uid' => 1,
            ]
        ];

        $result = $this->subject->getEntityToStop($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Step', $result);
    }

    /**
     * @test
     */
    public function getEntityToStopWithQuestionReturnsParentStep ()
    {
        /**
         * Scenario:
         *
         * Given is a Question
         * Given is a TCA array request with \Question
         * When the function is called
         * Then the parent step is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        // is representing the Section-Entity with UID 1; according to the checkup with UID 1
        $tcaArray = [
            'table' => 'tx_rkwcheckup_domain_model_question',
            'row' => [
                'uid' => 1,
            ]
        ];

        $result = $this->subject->getEntityToStop($tcaArray);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Step', $result);
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
