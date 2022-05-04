<?php
namespace RKW\RkwCheckup\Domain\Model;

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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Result
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Result extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate;

    
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
     * showStepFeedback
     *
     * @var bool
     */
    protected $showStepFeedback = false;

    
    /**
     * showSectionIntro
     *
     * @var bool
     */
    protected $showSectionIntro = false;

    
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
    protected $checkup;

    
    /**
     * currentSection
     *
     * @var \RKW\RkwCheckup\Domain\Model\Section
     */
    protected $currentSection;

    
    /**
     * currentStep
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $currentStep;

    
    /**
     * resultAnswer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $resultAnswer;

    
    /**
     * newResultAnswer
     * Hint: Should never be persisted. Just needed for FE form to validate and creating new answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $newResultAnswer;

    
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
    public function getHash(): string
    {
        return $this->hash;
    }

    
    /**
     * Sets the hash
     *
     * @param string $hash
     * @return void
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    
    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    
    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }
    
    

    /**
     * @return bool
     */
    public function isLastStep(): bool
    {
        return $this->lastStep;
    }

    
    /**
     * @param bool $lastStep
     */
    public function setLastStep(bool $lastStep): void
    {
        $this->lastStep = $lastStep;
    }

    
    /**
     * @return bool
     */
    public function isShowStepFeedback(): bool
    {
        return $this->showStepFeedback;
    }

    
    /**
     * @param bool $showStepFeedback
     */
    public function setShowStepFeedback(bool $showStepFeedback): void
    {
        $this->showStepFeedback = $showStepFeedback;
    }

    
    /**
     * @return bool
     */
    public function isShowSectionIntro(): bool
    {
        return $this->showSectionIntro;
    }
    

    /**
     * @param bool $showSectionIntro
     */
    public function setShowSectionIntro(bool $showSectionIntro): void
    {
        $this->showSectionIntro = $showSectionIntro;
    }
    

    /**
     * Returns the checkup
     *
     * @return \RKW\RkwCheckup\Domain\Model\Checkup|null $checkup
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
    public function setCheckup(\RKW\RkwCheckup\Domain\Model\Checkup $checkup): void
    {
        $this->checkup = $checkup;
    }

    
    /**
     * Adds a resultAnswer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer
     * @return void
     * @api
     */
    public function addResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswer): void
    {
        $this->resultAnswer->attach($resultAnswer);
    }

    
    /**
     * Removes a resultAnswer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswerToRemove The ResultAnswer to be removed
     * @return void
     * @api
     */
    public function removeResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $resultAnswerToRemove): void
    {
        $this->resultAnswer->detach($resultAnswerToRemove);
    }
    

    /**
     * Returns the resultAnswer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> resultAnswer
     * @api
     */
    public function getResultAnswer(): ObjectStorage
    {
        return $this->resultAnswer;
    }
    

    /**
     * Sets the resultAnswer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> $resultAnswer
     * @return void
     * @api
     */
    public function setResultAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resultAnswer): void
    {
        $this->resultAnswer = $resultAnswer;
    }

    
    /**
     * Adds a newResultAnswer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer
     * @return void
     * @api
     */
    public function addNewResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswer): void
    {
        $this->newResultAnswer->attach($newResultAnswer);
    }

    
    /**
     * Removes a newResultAnswer
     *
     * @param \RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswerToRemove The ResultAnswer to be removed
     * @return void
     * @api
     */
    public function removeNewResultAnswer(\RKW\RkwCheckup\Domain\Model\ResultAnswer $newResultAnswerToRemove): void
    {
        $this->newResultAnswer->detach($newResultAnswerToRemove);
    }

    
    /**
     * Returns the newResultAnswer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> newResultAnswer
     * @api
     */
    public function getNewResultAnswer(): ObjectStorage
    {
        return $this->newResultAnswer;
    }
    

    /**
     * Sets the newResultAnswer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer> $newResultAnswer
     * @return void
     */
    public function setNewResultAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $newResultAnswer): void
    {
        $this->newResultAnswer = $newResultAnswer;
    }

    
    /**
     * Returns the currentSection
     *
     * @return \RKW\RkwCheckup\Domain\Model\Section|null $currentSection
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
    public function setCurrentSection(\RKW\RkwCheckup\Domain\Model\Section $currentSection): void
    {
        $this->currentSection = $currentSection;
    }
    

    /**
     * Returns the currentStep
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step|null $currentStep
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
    public function setCurrentStep(\RKW\RkwCheckup\Domain\Model\Step $currentStep): void
    {
        $this->currentStep = $currentStep;
    }
}
