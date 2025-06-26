<?php
namespace RKW\RkwCheckup\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Repository\CheckupRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwCheckup\Export\CsvExport;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\Exception;

/**
 * Class BackendController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendController extends ActionController
{
    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ?CheckupRepository $checkupRepository = null;


    /**
     * resultRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ?ResultRepository $resultRepository = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     */
    public function injectCheckupRepository(CheckupRepository $checkupRepository)
    {
        $this->checkupRepository = $checkupRepository;
    }


    /**
     * @var \RKW\RkwCheckup\Domain\Repository\ResultRepository
     */
    public function injectResultRepository(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }


    /**
     * action list
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup|null $checkup
     * @return void
     */
    public function listAction(Checkup $checkup = null): void
    {
        if ($checkup) {
            $this->view->assign('checkResultList', $this->resultRepository->getFinishedByCheck($checkup));
            $this->view->assign('checkup', $checkup);
        } else {
            $this->view->assign('checkList', $this->checkupRepository->findAllIgnorePid());
        }
    }


    /**
     * action show
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return void
     */
    public function showAction(Checkup $checkup): void
    {
        $this->view->assign('enableGoogleChart', true);
        $this->view->assign('checkupResultCountTotal', $this->resultRepository->getFinishedByCheck($checkup)->count());
        $this->view->assign('checkup', $checkup);
    }


    /**
     * csvExport
     *
     * @param Checkup $checkup
     * @return void
     * @throws Exception
     */
    public function csvExportAction(Checkup $checkup): void
    {
        CsvExport::createCsv($checkup);
        exit;
    }

}
