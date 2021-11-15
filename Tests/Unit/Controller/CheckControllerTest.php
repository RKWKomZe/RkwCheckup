<?php
namespace RKW\RkwCheckup\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class CheckControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \RKW\RkwCheckup\Controller\CheckController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\RKW\RkwCheckup\Controller\CheckController::class)
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
    public function listActionFetchesAllChecksFromRepositoryAndAssignsThemToView()
    {

        $allChecks = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $checkRepository = $this->getMockBuilder(\RKW\RkwCheckup\Domain\Repository\CheckRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $checkRepository->expects(self::once())->method('findAll')->will(self::returnValue($allChecks));
        $this->inject($this->subject, 'checkRepository', $checkRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('checks', $allChecks);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCheckToView()
    {
        $check = new \RKW\RkwCheckup\Domain\Model\Check();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('check', $check);

        $this->subject->showAction($check);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCheckToCheckRepository()
    {
        $check = new \RKW\RkwCheckup\Domain\Model\Check();

        $checkRepository = $this->getMockBuilder(\RKW\RkwCheckup\Domain\Repository\CheckRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $checkRepository->expects(self::once())->method('add')->with($check);
        $this->inject($this->subject, 'checkRepository', $checkRepository);

        $this->subject->createAction($check);
    }
}
