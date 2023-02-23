<?php
namespace RKW\RkwCheckup\Tests\Functional\Step;
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
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Repository\AnswerRepository;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\QuestionRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Domain\Repository\SectionRepository;
use RKW\RkwCheckup\Domain\Repository\StepRepository;
use RKW\RkwCheckup\Step\ProgressHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * ProgressHandlerTest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ProgressHandlerTest extends FunctionalTestCase
{
    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/ProgressHandlerTest/Fixtures';


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
     * @var \RKW\RkwCheckup\Step\ProgressHandler|null
     */
    private ?ProgressHandler $subject = null;


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
    private ?AnswerRepository $resultRepository = null;


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

        $this->subject = $this->objectManager->get(ProgressHandler::class);
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
    public function newResultWithCheckupReturnsResult ()
    {
        /**
         * Scenario:
         *
         * Given is a Checkup
         * When the function is called
         * Then a new result is created
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');

        $check = $this->checkupRepository->findByIdentifier(1);

        self::assertNull($this->subject->getResult());

        $this->subject->newResult($check);

        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Result', $this->subject->getResult());

        self::assertFalse($this->subject->getResult()->getLastStep());

        // some additional "result" checks
        self::assertNotNull($this->subject->getResult()->getHash());
        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Checkup', $this->subject->getResult()->getCheckup());
        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Section', $this->subject->getResult()->getCurrentSection());
        self::assertInstanceOf('\RKW\RkwCheckup\Domain\Model\Step', $this->subject->getResult()->getCurrentStep());
        self::assertTrue($this->subject->getResult()->getShowSectionIntro());
    }

    //===================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithNotMandatoryQuestionAndNoAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (not mandatory)
         * Given are NO answers
         * When the function is called
         * Then an empty string is returned because there is no error message
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        $result = $this->resultRepository->findByIdentifier(1);
        $currentQuestion = $this->questionRepository->findByIdentifier(1);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($currentQuestion);

        self::assertEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithNotMandatoryQuestionAndAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (not mandatory)
         * Given is a resultAnswer
         * When the function is called
         * Then an empty string is returned because there is no error message
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(1);
        $answer = $this->answerRepository->findByIdentifier(1);

        // simulate user given form results to validate
        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);

        // add not persistent newResultAnswer
        $result->addNewResultAnswer($newResultAnswer);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryQuestionAndAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (mandatory!)
         * Given is a resultAnswer
         * When the function is called
         * Then an empty string is returned because there is no error message
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(2);
        $answer = $this->answerRepository->findByIdentifier(4);

        // simulate user given form results to validate
        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);

        // add not persistent newResultAnswer
        $result->addNewResultAnswer($newResultAnswer);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryQuestionAndNoAnswersReturnsErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (mandatory!)
         * When the function is called
         * Then an error message is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(2);

        // NO answer is set!!

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertNotEquals('', $returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryMultipleChoiceQuestionNoAnswersReturnsErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (multipleChoice; mandatory; minCheck = 2; maxCheck = 4)
         * When the function is called
         * Then an error message is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertNotEquals('', $returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryMultipleChoiceQuestionNotEnoughAnswersReturnsErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (multipleChoice; mandatory; minCheck = 2; maxCheck = 4)
         * Given is a resultAnswer
         * When the function is called
         * Then an error message is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer = $this->answerRepository->findByIdentifier(7);

        // simulate user given form results to validate
        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);

        // add not persistent newResultAnswer
        $result->addNewResultAnswer($newResultAnswer);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertNotEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryMultipleChoiceQuestionWithEnoughAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (multipleChoice; mandatory; minCheck = 2; maxCheck = 4)
         * Given are two resultAnswer
         * When the function is called
         * Then an empty string is returned because there is no error message
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer1 = $this->answerRepository->findByIdentifier(7);
        $answer2 = $this->answerRepository->findByIdentifier(8);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer1 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer1->setSection($section);
        $newResultAnswer1->setStep($step);
        $newResultAnswer1->setQuestion($question);
        $newResultAnswer1->setAnswer($answer1);
        $result->addNewResultAnswer($newResultAnswer1);

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer2 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer2->setSection($section);
        $newResultAnswer2->setStep($step);
        $newResultAnswer2->setQuestion($question);
        $newResultAnswer2->setAnswer($answer2);
        $result->addNewResultAnswer($newResultAnswer2);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryMultipleChoiceQuestionWithOneMoreAsNecessaryAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (multipleChoice; mandatory; minCheck = 2; maxCheck = 4)
         * Given are three resultAnswer
         * When the function is called
         * Then an empty string is returned because there is no error message
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer1 = $this->answerRepository->findByIdentifier(7);
        $answer2 = $this->answerRepository->findByIdentifier(8);
        $answer3 = $this->answerRepository->findByIdentifier(9);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer1 */
        $newResultAnswer1 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer1->setSection($section);
        $newResultAnswer1->setStep($step);
        $newResultAnswer1->setQuestion($question);
        $newResultAnswer1->setAnswer($answer1);
        $result->addNewResultAnswer($newResultAnswer1);

        /** @var ResultAnswer $newResultAnswer2 */
        $newResultAnswer2 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer2->setSection($section);
        $newResultAnswer2->setStep($step);
        $newResultAnswer2->setQuestion($question);
        $newResultAnswer2->setAnswer($answer2);
        $result->addNewResultAnswer($newResultAnswer2);

        /** @var ResultAnswer $newResultAnswer3 */
        $newResultAnswer3 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer3->setSection($section);
        $newResultAnswer3->setStep($step);
        $newResultAnswer3->setQuestion($question);
        $newResultAnswer3->setAnswer($answer3);
        $result->addNewResultAnswer($newResultAnswer3);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertEmpty($returnValue);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function validateQuestionWithMandatoryMultipleChoiceQuestionWithTooMuchAnswersReturnsNoErrorMessage ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a question (multipleChoice; mandatory; minCheck = 2; maxCheck = 4)
         * Given are four resultAnswer
         * When the function is called
         * Then an error message is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer1 = $this->answerRepository->findByIdentifier(7);
        $answer2 = $this->answerRepository->findByIdentifier(8);
        $answer3 = $this->answerRepository->findByIdentifier(9);
        $answer4 = $this->answerRepository->findByIdentifier(10);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer1 */
        $newResultAnswer1 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer1->setSection($section);
        $newResultAnswer1->setStep($step);
        $newResultAnswer1->setQuestion($question);
        $newResultAnswer1->setAnswer($answer1);
        $result->addNewResultAnswer($newResultAnswer1);

        /** @var ResultAnswer $newResultAnswer2 */
        $newResultAnswer2 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer2->setSection($section);
        $newResultAnswer2->setStep($step);
        $newResultAnswer2->setQuestion($question);
        $newResultAnswer2->setAnswer($answer2);
        $result->addNewResultAnswer($newResultAnswer2);

        /** @var ResultAnswer $newResultAnswer3 */
        $newResultAnswer3 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer3->setSection($section);
        $newResultAnswer3->setStep($step);
        $newResultAnswer3->setQuestion($question);
        $newResultAnswer3->setAnswer($answer3);
        $result->addNewResultAnswer($newResultAnswer3);

        /** @var ResultAnswer $newResultAnswer4 */
        $newResultAnswer4 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer4->setSection($section);
        $newResultAnswer4->setStep($step);
        $newResultAnswer4->setQuestion($question);
        $newResultAnswer4->setAnswer($answer4);
        $result->addNewResultAnswer($newResultAnswer4);

        $this->subject->setResult($result);
        $returnValue = $this->subject->validateQuestion($question);

        self::assertNotEmpty($returnValue);
    }

    //===================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function moveNewResultAnswersWithNewResultAnswersPersistNewAnswers ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given are two newResultAnswer
         * When the function is called
         * Then two new resultAnswers created
         * Then the newResultAnswers are deleted
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer1 = $this->answerRepository->findByIdentifier(7);
        $answer2 = $this->answerRepository->findByIdentifier(8);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer1 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer1->setSection($section);
        $newResultAnswer1->setStep($step);
        $newResultAnswer1->setQuestion($question);
        $newResultAnswer1->setAnswer($answer1);
        $result->addNewResultAnswer($newResultAnswer1);

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer2 = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer2->setSection($section);
        $newResultAnswer2->setStep($step);
        $newResultAnswer2->setQuestion($question);
        $newResultAnswer2->setAnswer($answer2);
        $result->addNewResultAnswer($newResultAnswer2);

        self::assertCount(0, $result->getResultAnswer());
        self::assertCount(2, $result->getNewResultAnswer());

        $this->subject->setResult($result);
        $this->subject->moveNewResultAnswers();

        self::assertCount(2, $result->getResultAnswer());
        self::assertCount(0, $result->getNewResultAnswer());
    }


    /**
     * @test
     * @throws \Exception
     */
    public function moveNewResultAnswersWithNoResultAnswersPersistNothing ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given are no resultAnswer
         * When the function is called
         * Then nothing changed
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);

        self::assertCount(0, $result->getResultAnswer());

        $this->subject->setResult($result);
        $this->subject->moveNewResultAnswers();

        self::assertCount(0, $result->getResultAnswer());
    }

    //===================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function progressValidationWithCorrectStepReturnsTrue ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a step
         * Given are newResultAnswers of this step
         * When the function is called
         * Then true is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer = $this->answerRepository->findByIdentifier(7);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);
        $result->addNewResultAnswer($newResultAnswer);

        $result->setCurrentStep($step);

        $this->subject->setResult($result);
        $returnValue = $this->subject->progressValidation();

        self::assertTrue($returnValue);

    }


    /**
     * @test
     * @throws \Exception
     */
    public function progressValidationWithDifferentStepReturnsFalse ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a step
         * Given are newResultAnswers of this step
         * Given is a different step which is the "currentStep" in result
         * When the function is called
         * Then false is returned
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer = $this->answerRepository->findByIdentifier(7);

        // simulate user given form results to validate

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);
        $result->addNewResultAnswer($newResultAnswer);

        $anotherStep = $this->stepRepository->findByIdentifier(2);

        $result->setCurrentStep($anotherStep);

        $this->subject->setResult($result);
        $returnValue = $this->subject->progressValidation();

        self::assertFalse($returnValue);

    }


    //===================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function persistNewResultAddsNewResultToDatabase ()
    {
        /**
         * Scenario:
         *
         * Given is a not persistent result
         * When the function is called
         * Then the result is persisted
         */

        /** @var Result $result */
        $result = $this->objectManager->get(Result::class);

        self::assertEmpty($result->getUid());

        $this->subject->setResult($result);
        $this->subject->persist();

        self::assertNotEmpty($result->getUid());

    }


    /**
     * @test
     * @throws \Exception
     */
    public function persistExistingResultUpdatesResult ()
    {
        /**
         * Scenario:
         *
         * Given is an already persistent result
         * Given is a newResultAnswer
         * When the function is called
         * Then the result is updated
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check10.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check100.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);

        self::assertCount(0, $result->getResultAnswer());

        // simulate user given form results to validate
        $section = $this->sectionRepository->findByIdentifier(1);
        $step = $this->stepRepository->findByIdentifier(1);
        $question = $this->questionRepository->findByIdentifier(3);
        $answer = $this->answerRepository->findByIdentifier(7);

        /** @var ResultAnswer $newResultAnswer */
        $newResultAnswer = $this->objectManager->get(ResultAnswer::class);
        $newResultAnswer->setSection($section);
        $newResultAnswer->setStep($step);
        $newResultAnswer->setQuestion($question);
        $newResultAnswer->setAnswer($answer);
        $result->addNewResultAnswer($newResultAnswer);

        $this->subject->setResult($result);
        $this->subject->moveNewResultAnswers();
        $this->subject->persist();

        self::assertCount(1, $result->getResultAnswer());

    }

    //===================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function setNextStepWithLastStepWhichIsNotShownByStepHideCond ()
    {
        /**
         * Scenario:
         *
         * Given is a result
         * Given is a resultAnswer with UID 1
         * Given is a step with a hideCondition with resultAnswer with UID 1
         * When the function is called
         * Then the following step is skipped
         * Then the "finished" flag is set
         */

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check20.xml');
        $this->importDataSet(self::FIXTURE_PATH . '/Database/Check110.xml');

        /** @var Result $result */
        $result = $this->resultRepository->findByIdentifier(1);
        $this->subject->setResult($result);

        // start: Section 1 and Step 1
        self::assertFalse($result->getLastStep());
        self::assertEquals(1, $result->getCurrentSection()->getUid());
        self::assertEquals(1, $result->getCurrentStep()->getUid());

        // do action
        $this->subject->setNextStep();

        //$result = $this->subject->getResult();

        self::assertTrue($result->getLastStep());

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
