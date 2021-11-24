<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class ResultTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Result
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Result();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getHashReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHash()
        );
    }

    /**
     * @test
     */
    public function setHashForStringSetsHash()
    {
        $this->subject->setHash('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'hash',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCheckupReturnsInitialValueForCheckup()
    {
        self::assertEquals(
            null,
            $this->subject->getCheckup()
        );
    }

    /**
     * @test
     */
    public function setCheckupForCheckupSetsCheckup()
    {
        $checkupFixture = new \RKW\RkwCheckup\Domain\Model\Checkup();
        $this->subject->setCheckup($checkupFixture);

        self::assertAttributeEquals(
            $checkupFixture,
            'checkup',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCurrentSectionReturnsInitialValueForSection()
    {
        self::assertEquals(
            null,
            $this->subject->getCurrentSection()
        );
    }

    /**
     * @test
     */
    public function setCurrentSectionForSectionSetsCurrentSection()
    {
        $currentSectionFixture = new \RKW\RkwCheckup\Domain\Model\Section();
        $this->subject->setCurrentSection($currentSectionFixture);

        self::assertAttributeEquals(
            $currentSectionFixture,
            'currentSection',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCurrentStepReturnsInitialValueForStep()
    {
        self::assertEquals(
            null,
            $this->subject->getCurrentStep()
        );
    }

    /**
     * @test
     */
    public function setCurrentStepForStepSetsCurrentStep()
    {
        $currentStepFixture = new \RKW\RkwCheckup\Domain\Model\Step();
        $this->subject->setCurrentStep($currentStepFixture);

        self::assertAttributeEquals(
            $currentStepFixture,
            'currentStep',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCurrentQuestionReturnsInitialValueForQuestion()
    {
        self::assertEquals(
            null,
            $this->subject->getCurrentQuestion()
        );
    }

    /**
     * @test
     */
    public function setCurrentQuestionForQuestionSetsCurrentQuestion()
    {
        $currentQuestionFixture = new \RKW\RkwCheckup\Domain\Model\Question();
        $this->subject->setCurrentQuestion($currentQuestionFixture);

        self::assertAttributeEquals(
            $currentQuestionFixture,
            'currentQuestion',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getResultAnswerReturnsInitialValueForResultAnswer()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getResultAnswer()
        );
    }

    /**
     * @test
     */
    public function setResultAnswerForObjectStorageContainingResultAnswerSetsResultAnswer()
    {
        $resultAnswer = new \RKW\RkwCheckup\Domain\Model\ResultAnswer();
        $objectStorageHoldingExactlyOneResultAnswer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneResultAnswer->attach($resultAnswer);
        $this->subject->setResultAnswer($objectStorageHoldingExactlyOneResultAnswer);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneResultAnswer,
            'resultAnswer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addResultAnswerToObjectStorageHoldingResultAnswer()
    {
        $resultAnswer = new \RKW\RkwCheckup\Domain\Model\ResultAnswer();
        $resultAnswerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $resultAnswerObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($resultAnswer));
        $this->inject($this->subject, 'resultAnswer', $resultAnswerObjectStorageMock);

        $this->subject->addResultAnswer($resultAnswer);
    }

    /**
     * @test
     */
    public function removeResultAnswerFromObjectStorageHoldingResultAnswer()
    {
        $resultAnswer = new \RKW\RkwCheckup\Domain\Model\ResultAnswer();
        $resultAnswerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $resultAnswerObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($resultAnswer));
        $this->inject($this->subject, 'resultAnswer', $resultAnswerObjectStorageMock);

        $this->subject->removeResultAnswer($resultAnswer);
    }
}
