<?php

namespace RKW\RkwCheckup\Service;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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

/**
 * Class ResultService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultService
{
    /**
     * Setting
     *
     * @var array
     */
    protected $settings;

    /**
     * @var \RKW\RkwCheckup\Domain\Model\Result
     */
    protected $result;

    /**
     * create new result
     *
     * @param $checkup
     * @return void
     */
    public function new ($checkup)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->result = $objectManager->get(Result::class);
        $this->result->setCheckup($checkup);
        // unique ID with timestamp as prefix
        $this->result->setHash(uniqid(time()));
    }

    /**
     * Returns result
     *
     * @return \RKW\RkwCheckup\Domain\Model\Result $result
     */
    public function get ()
    {
        return $this->result;
    }

    /**
     * set current step (for progress calculation)
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function setStep ($step)
    {
        $this->result->setStep($step);
    }

    /**
     * persist
     *
     * @return void
     */
    public function persist ()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \RKW\RkwCheckup\Domain\Repository\ResultRepository $resultRepository */
        $resultRepository = $objectManager->get(ResultRepository::class);
        if ($this->result->_isNew()) {
            $resultRepository->add($this->result);
        } else {
            $resultRepository->update($this->result);
        }

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager */
        $persistenceManager = $objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
    }

    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    public function getLogger ()
    {
        return GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
    }

    /**
     * Returns TYPO3 settings
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings ()
    {

        if (!$this->settings) {
            $this->settings = GeneralUtility::getTyposcriptConfiguration('Rkwcheckup');
        }


        if (!$this->settings) {
            return array();
        }

        return $this->settings;
    }


}