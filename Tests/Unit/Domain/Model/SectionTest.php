<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class SectionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Section
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Section();
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
    public function getHideTextReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getHideText()
        );
    }

    /**
     * @test
     */
    public function setHideTextForBoolSetsHideText()
    {
        $this->subject->setHideText(true);

        self::assertAttributeEquals(
            true,
            'hideText',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectionReturnsInitialValueForStep()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSection()
        );
    }

    /**
     * @test
     */
    public function setSectionForObjectStorageContainingStepSetsSection()
    {
        $section = new \RKW\RkwCheckup\Domain\Model\Step();
        $objectStorageHoldingExactlyOneSection = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSection->attach($section);
        $this->subject->setSection($objectStorageHoldingExactlyOneSection);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneSection,
            'section',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addSectionToObjectStorageHoldingSection()
    {
        $section = new \RKW\RkwCheckup\Domain\Model\Step();
        $sectionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($section));
        $this->inject($this->subject, 'section', $sectionObjectStorageMock);

        $this->subject->addSection($section);
    }

    /**
     * @test
     */
    public function removeSectionFromObjectStorageHoldingSection()
    {
        $section = new \RKW\RkwCheckup\Domain\Model\Step();
        $sectionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($section));
        $this->inject($this->subject, 'section', $sectionObjectStorageMock);

        $this->subject->removeSection($section);
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
