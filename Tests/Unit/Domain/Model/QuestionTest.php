<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class QuestionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Question
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Question();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTypeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getType()
        );
    }

    /**
     * @test
     */
    public function setTypeForStringSetsType()
    {
        $this->subject->setType('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'type',
            $this->subject
        );
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
    public function getMandatoryReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getMandatory()
        );
    }

    /**
     * @test
     */
    public function setMandatoryForBoolSetsMandatory()
    {
        $this->subject->setMandatory(true);

        self::assertAttributeEquals(
            true,
            'mandatory',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMinCheckReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getMinCheck()
        );
    }

    /**
     * @test
     */
    public function setMinCheckForIntSetsMinCheck()
    {
        $this->subject->setMinCheck(12);

        self::assertAttributeEquals(
            12,
            'minCheck',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaxCheckReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMaxCheck()
        );
    }

    /**
     * @test
     */
    public function setMaxCheckForStringSetsMaxCheck()
    {
        $this->subject->setMaxCheck('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'maxCheck',
            $this->subject
        );
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
}
