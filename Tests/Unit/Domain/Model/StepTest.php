<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class StepTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Step();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForQuestion()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getQuestion()
        );
    }

    /**
     * @test
     */
    public function setQuestionForObjectStorageContainingQuestionSetsQuestion()
    {
        $question = new \RKW\RkwCheckup\Domain\Model\Question();
        $objectStorageHoldingExactlyOneQuestion = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneQuestion->attach($question);
        $this->subject->setQuestion($objectStorageHoldingExactlyOneQuestion);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneQuestion,
            'question',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addQuestionToObjectStorageHoldingQuestion()
    {
        $question = new \RKW\RkwCheckup\Domain\Model\Question();
        $questionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($question));
        $this->inject($this->subject, 'question', $questionObjectStorageMock);

        $this->subject->addQuestion($question);
    }

    /**
     * @test
     */
    public function removeQuestionFromObjectStorageHoldingQuestion()
    {
        $question = new \RKW\RkwCheckup\Domain\Model\Question();
        $questionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($question));
        $this->inject($this->subject, 'question', $questionObjectStorageMock);

        $this->subject->removeQuestion($question);
    }

    /**
     * @test
     */
    public function getHideCondReturnsInitialValueForAnswer()
    {
        self::assertEquals(
            null,
            $this->subject->getHideCond()
        );
    }

    /**
     * @test
     */
    public function setHideCondForAnswerSetsHideCond()
    {
        $hideCondFixture = new \RKW\RkwCheckup\Domain\Model\Answer();
        $this->subject->setHideCond($hideCondFixture);

        self::assertAttributeEquals(
            $hideCondFixture,
            'hideCond',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStepFeedbackReturnsInitialValueForStepFeedback()
    {
        self::assertEquals(
            null,
            $this->subject->getStepFeedback()
        );
    }

    /**
     * @test
     */
    public function setStepFeedbackForStepFeedbackSetsStepFeedback()
    {
        $stepFeedbackFixture = new \RKW\RkwCheckup\Domain\Model\StepFeedback();
        $this->subject->setStepFeedback($stepFeedbackFixture);

        self::assertAttributeEquals(
            $stepFeedbackFixture,
            'stepFeedback',
            $this->subject
        );
    }
}
