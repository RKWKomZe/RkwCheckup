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
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Result extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     *
     * @todo How to set typecast and default value without overriding systems crdate? (was always persisted with value "0")
     */
    protected $crdate;


    /**
     * @var bool
     */
    protected bool $finished = false;


    /**
     * @var bool
     */
    protected bool $lastStep = false;


    /**
     * @var bool
     */
    protected bool $showStepFeedback = false;


    /**
     * @var bool
     */
    protected bool $showSectionIntro = false;


    /**
     * @var string
     */
    protected string $hash = '';


    /**
     * @var \RKW\RkwCheckup\Domain\Model\Checkup|null
     */
    protected ?Checkup $checkup = null;


    /**
     * currentSection
     *
     * @var \RKW\RkwCheckup\Domain\Model\Section|null
     */
    protected ?Section $currentSection = null;


    /**
     * currentStep
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step|null
     */
    protected ?Step $currentStep = null;


    /**
     * resultAnswer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $resultAnswer = null;


    /**
     * newResultAnswer
     * Hint: Should never be persisted. Just needed for FE form to validate and creating new answers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $newResultAnswer = null;


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
    protected function initStorageObjects(): void
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
    public function getFinished(): bool
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
    public function getLastStep(): bool
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
    public function getShowStepFeedback(): bool
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
    public function getShowSectionIntro(): bool
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
    public function getCheckup():? Checkup
    {
        return $this->checkup;
    }


    /**
     * Sets the checkup
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return void
     */
    public function setCheckup(Checkup $checkup): void
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
    public function addResultAnswer(ResultAnswer $resultAnswer): void
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
    public function removeResultAnswer(ResultAnswer $resultAnswerToRemove): void
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
    public function setResultAnswer(ObjectStorage $resultAnswer): void
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
    public function addNewResultAnswer(ResultAnswer $newResultAnswer): void
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
    public function removeNewResultAnswer(ResultAnswer $newResultAnswerToRemove): void
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
    public function setNewResultAnswer(ObjectStorage $newResultAnswer): void
    {
        $this->newResultAnswer = $newResultAnswer;
    }


    /**
     * Returns the currentSection
     *
     * @return \RKW\RkwCheckup\Domain\Model\Section|null $currentSection
     */
    public function getCurrentSection():? Section
    {
        return $this->currentSection;
    }


    /**
     * Sets the currentSection
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section|null $currentSection
     * @return void
     */
    public function setCurrentSection(?Section $currentSection): void
    {
        $this->currentSection = $currentSection;
    }


    /**
     * Returns the currentStep
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step|null $currentStep
     */
    public function getCurrentStep():? Step
    {
        return $this->currentStep;
    }


    /**
     * Sets the currentStep
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step|null $currentStep
     * @return void
     */
    public function setCurrentStep(?Step $currentStep): void
    {
        $this->currentStep = $currentStep;
    }
}
