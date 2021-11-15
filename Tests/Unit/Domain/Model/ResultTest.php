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
    public function getAnswerReturnsInitialValueForAnswer()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAnswer()
        );
    }

    /**
     * @test
     */
    public function setAnswerForObjectStorageContainingAnswerSetsAnswer()
    {
        $answer = new \RKW\RkwCheckup\Domain\Model\Answer();
        $objectStorageHoldingExactlyOneAnswer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAnswer->attach($answer);
        $this->subject->setAnswer($objectStorageHoldingExactlyOneAnswer);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAnswer,
            'answer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAnswerToObjectStorageHoldingAnswer()
    {
        $answer = new \RKW\RkwCheckup\Domain\Model\Answer();
        $answerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answerObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($answer));
        $this->inject($this->subject, 'answer', $answerObjectStorageMock);

        $this->subject->addAnswer($answer);
    }

    /**
     * @test
     */
    public function removeAnswerFromObjectStorageHoldingAnswer()
    {
        $answer = new \RKW\RkwCheckup\Domain\Model\Answer();
        $answerObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answerObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($answer));
        $this->inject($this->subject, 'answer', $answerObjectStorageMock);

        $this->subject->removeAnswer($answer);
    }
}
