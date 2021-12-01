<?php
namespace RKW\RkwCheckup\Domain\Model;

/***
 *
 * This file is part of the "RKW Checkup" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Maximilian Fäßler <maximilian@faesslerweb.de>, Fäßler Web UG
 *
 ***/

/**
 * Result
 */
class Result extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate = 0;


    /**
     * finished
     *
     * @var bool
     */
    protected $finished = false;

    /**
     * lastStep
     *
     * @var bool
     */
    protected $lastStep = false;

    /**
     * For unique link building
     *
     * @var string
     */
    protected $hash = '';

    /**
     * checkup
     *
     * @var \RKW\RkwCheckup\Domain\Model\Checkup
     */
    protected $checkup = null;

    /**
     * currentSection
     *
     * @var \RKW\RkwCheckup\Domain\Model\Section
     */
    protected $currentSection = null;

    /**
     * currentStep
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $currentStep = null;

    /**
     * resultAnswer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $resultAnswer = null;

    /**
     * newResultAnswer
     * Hint: Should never persistent. Just needed for FE form to validate and creating new answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $newResultAnswer = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->resultAnswer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->newResultAnswer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }

    /**
     * @param int $crdate
     */
    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the hash
     *
     * @return string $hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Sets the hash
     *
     * @param string $hash
     * @return void
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @param bool $finished
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;
    }

    /**
     * @return bool
     */
    public function isLastStep()
    {
        return $this->lastStep;
    }

    /**
     * @param bool $lastStep
     */
    public function setLastStep($lastStep)
    {
        $this->lastStep = $lastStep;
    }

    /**
     * Returns the checkup
     *
     * @return \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     */
    public function getCheckup()
    {
        return $this->checkup;
    }

    /**
     * Sets the checkup
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return void
     */
    public function setCheckup(\RKW\RkwCheckup\Domain\Model\Checkup $checkup)
    {
        $this->checkup = $checkup;
    }

    /**
     * Adds a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer
     * @return void
     */
    public function addResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer)
    {
        $this->resultAnswer->attach($resultAnswer);
    }

    /**
     * Removes a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswerToRemove The ResultAnswer to be removed
     * @return void
     */
    public function removeResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswerToRemove)
    {
        $this->resultAnswer->detach($resultAnswerToRemove);
    }

    /**
     * Returns the resultAnswer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> resultAnswer
     */
    public function getResultAnswer()
    {
        return $this->resultAnswer;
    }

    /**
     * Sets the resultAnswer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> $resultAnswer
     * @return void
     */
    public function setResultAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultAnswer)
    {
        $this->resultAnswer = $resultAnswer;
    }

    /**
     * Adds a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer
     * @return void
     */
    public function addNewResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer)
    {
        $this->newResultAnswer->attach($newResultAnswer);
    }

    /**
     * Removes a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswerToRemove The ResultAnswer to be removed
     * @return void
     */
    public function removeNewResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswerToRemove)
    {
        $this->newResultAnswer->detach($newResultAnswerToRemove);
    }

    /**
     * Returns the newResultAnswer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> newResultAnswer
     */
    public function getNewResultAnswer()
    {
        return $this->newResultAnswer;
    }

    /**
     * Sets the newResultAnswer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> $newResultAnswer
     * @return void
     */
    public function setNewResultAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $newResultAnswer)
    {
        $this->newResultAnswer = $newResultAnswer;
    }

    /**
     * Returns the currentSection
     *
     * @return \RKW\RkwCheckup\Domain\Model\Section $currentSection
     */
    public function getCurrentSection()
    {
        return $this->currentSection;
    }

    /**
     * Sets the currentSection
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $currentSection
     * @return void
     */
    public function setCurrentSection(\RKW\RkwCheckup\Domain\Model\Section $currentSection)
    {
        $this->currentSection = $currentSection;
    }

    /**
     * Returns the currentStep
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step currentStep
     */
    public function getCurrentStep()
    {
        return $this->currentStep;
    }

    /**
     * Sets the currentStep
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $currentStep
     * @return void
     */
    public function setCurrentStep(\RKW\RkwCheckup\Domain\Model\Step $currentStep)
    {
        $this->currentStep = $currentStep;
    }
}
