<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class ChapterTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Chapter
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Chapter();
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
    public function getStepReturnsInitialValueForStep()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getStep()
        );
    }

    /**
     * @test
     */
    public function setStepForObjectStorageContainingStepSetsStep()
    {
        $step = new \RKW\RkwCheckup\Domain\Model\Step();
        $objectStorageHoldingExactlyOneStep = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneStep->attach($step);
        $this->subject->setStep($objectStorageHoldingExactlyOneStep);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneStep,
            'step',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addStepToObjectStorageHoldingStep()
    {
        $step = new \RKW\RkwCheckup\Domain\Model\Step();
        $stepObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $stepObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($step));
        $this->inject($this->subject, 'step', $stepObjectStorageMock);

        $this->subject->addStep($step);
    }

    /**
     * @test
     */
    public function removeStepFromObjectStorageHoldingStep()
    {
        $step = new \RKW\RkwCheckup\Domain\Model\Step();
        $stepObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $stepObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($step));
        $this->inject($this->subject, 'step', $stepObjectStorageMock);

        $this->subject->removeStep($step);
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
    public function getInterimResultReturnsInitialValueForInterimResult()
    {
        self::assertEquals(
            null,
            $this->subject->getInterimResult()
        );
    }

    /**
     * @test
     */
    public function setInterimResultForInterimResultSetsInterimResult()
    {
        $interimResultFixture = new \RKW\RkwCheckup\Domain\Model\InterimResult();
        $this->subject->setInterimResult($interimResultFixture);

        self::assertAttributeEquals(
            $interimResultFixture,
            'interimResult',
            $this->subject
        );
    }
}
