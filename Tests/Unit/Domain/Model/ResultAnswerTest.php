<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class ResultAnswerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\ResultAnswer
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\ResultAnswer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAnswerReturnsInitialValueForAnswer()
    {
        self::assertEquals(
            null,
            $this->subject->getAnswer()
        );
    }

    /**
     * @test
     */
    public function setAnswerForAnswerSetsAnswer()
    {
        $answerFixture = new \RKW\RkwCheckup\Domain\Model\Answer();
        $this->subject->setAnswer($answerFixture);

        self::assertAttributeEquals(
            $answerFixture,
            'answer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForQuestion()
    {
        self::assertEquals(
            null,
            $this->subject->getQuestion()
        );
    }

    /**
     * @test
     */
    public function setQuestionForQuestionSetsQuestion()
    {
        $questionFixture = new \RKW\RkwCheckup\Domain\Model\Question();
        $this->subject->setQuestion($questionFixture);

        self::assertAttributeEquals(
            $questionFixture,
            'question',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStepReturnsInitialValueForStep()
    {
        self::assertEquals(
            null,
            $this->subject->getStep()
        );
    }

    /**
     * @test
     */
    public function setStepForStepSetsStep()
    {
        $stepFixture = new \RKW\RkwCheckup\Domain\Model\Step();
        $this->subject->setStep($stepFixture);

        self::assertAttributeEquals(
            $stepFixture,
            'step',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectionReturnsInitialValueForSection()
    {
        self::assertEquals(
            null,
            $this->subject->getSection()
        );
    }

    /**
     * @test
     */
    public function setSectionForSectionSetsSection()
    {
        $sectionFixture = new \RKW\RkwCheckup\Domain\Model\Section();
        $this->subject->setSection($sectionFixture);

        self::assertAttributeEquals(
            $sectionFixture,
            'section',
            $this->subject
        );
    }
}
