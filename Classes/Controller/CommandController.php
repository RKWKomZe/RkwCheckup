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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * CommandController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * objectManager
     *
     * @var ObjectManager
     */
    protected $objectManager;


    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * checkupRepository
     *
     * @var \RKW\RkwCheckup\Domain\Repository\CheckupRepository
     * @inject
     */
    protected $checkupRepository = null;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * Initialize the controller.
     */
    protected function initializeController()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }


    /**
     * Cleanup abandoned wepstra projects of anonymous users
     * !! DANGER !! Cleanup executes a real MySQL-Delete- Query!!!
     *
     * @param integer $daysFromNow Defines which datasets (in days from now) will be deleted (crdate is reference)
     * @return void
     */
    public function cleanupAbandonedCommand($daysFromNow = 730)
    {

        try {

            if ($cleanupTimestamp = time() - intval($daysFromNow) * 24 * 60 * 60) {

                if (
                    ($wepstraList = $this->wepstraRepository->findAbandoned($cleanupTimestamp))
                    && is_countable($wepstraList)
                    && (count($wepstraList))
                ) {

                    /** @var \RKW\RkwWepstra\Domain\Model\Wepstra $wepstraToDelete */
                    foreach ($wepstraList as $wepstra) {
                        $this->deleteCheckup($wepstra);
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully deleted WePstra-project %s and all its sub-objects.', $wepstra->getUid()));
                    }

                } else {
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Nothing to clean up in database (AbandonedCleanup).');
                }
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occured: %s', $e->getMessage()));
        }
    }


    /**
     * Deletes a Checkup-project with all of its sub-objects
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkupToDelete
     * @return void
     */
    protected function deleteCheckup(\RKW\RkwCheckup\Domain\Model\Checkup $checkupToDelete)
    {


        // 1.13 checkup itself
        $this->checkupRepository->removeHard($checkupToDelete);
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {
        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}