<?php
namespace RKW\RkwCheckup\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class CheckupControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Controller\CheckupController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\RKW\RkwCheckup\Controller\CheckupController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllCheckupsFromRepositoryAndAssignsThemToView()
    {

        $allCheckups = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $checkupRepository = $this->getMockBuilder(\RKW\RkwCheckup\Domain\Repository\CheckupRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $checkupRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCheckups));
        $this->inject($this->subject, 'checkupRepository', $checkupRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('checkups', $allCheckups);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCheckupToView()
    {
        $checkup = new \RKW\RkwCheckup\Domain\Model\Checkup();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('checkup', $checkup);

        $this->subject->showAction($checkup);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCheckupToCheckupRepository()
    {
        $checkup = new \RKW\RkwCheckup\Domain\Model\Checkup();

        $checkupRepository = $this->getMockBuilder(\RKW\RkwCheckup\Domain\Repository\CheckupRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $checkupRepository->expects(self::once())->method('add')->with($checkup);
        $this->inject($this->subject, 'checkupRepository', $checkupRepository);

        $this->subject->createAction($checkup);
    }
}
