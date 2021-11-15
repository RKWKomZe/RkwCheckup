<?php
namespace RKW\RkwCheckup\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class CheckTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Domain\Model\Check
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwCheckup\Domain\Model\Check();
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
    public function getChapterReturnsInitialValueForChapter()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getChapter()
        );
    }

    /**
     * @test
     */
    public function setChapterForObjectStorageContainingChapterSetsChapter()
    {
        $chapter = new \RKW\RkwCheckup\Domain\Model\Chapter();
        $objectStorageHoldingExactlyOneChapter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneChapter->attach($chapter);
        $this->subject->setChapter($objectStorageHoldingExactlyOneChapter);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneChapter,
            'chapter',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addChapterToObjectStorageHoldingChapter()
    {
        $chapter = new \RKW\RkwCheckup\Domain\Model\Chapter();
        $chapterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $chapterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($chapter));
        $this->inject($this->subject, 'chapter', $chapterObjectStorageMock);

        $this->subject->addChapter($chapter);
    }

    /**
     * @test
     */
    public function removeChapterFromObjectStorageHoldingChapter()
    {
        $chapter = new \RKW\RkwCheckup\Domain\Model\Chapter();
        $chapterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $chapterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($chapter));
        $this->inject($this->subject, 'chapter', $chapterObjectStorageMock);

        $this->subject->removeChapter($chapter);
    }
}
