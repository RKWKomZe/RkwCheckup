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
     * finished
     *
     * @var bool
     */
    protected $finished = 0;

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
     * currentQuestion
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     */
    protected $currentQuestion = null;

    /**
     * resultAnswer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\ResultAnswer>
     * @cascade remove
     */
    protected $resultAnswer = null;

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
     * Returns the currentQuestion
     *
     * @return \RKW\RkwCheckup\Domain\Model\Question $currentQuestion
     */
    public function getCurrentQuestion()
    {
        return $this->currentQuestion;
    }

    /**
     * Sets the currentQuestion
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $currentQuestion
     * @return void
     */
    public function setCurrentQuestion(\RKW\RkwCheckup\Domain\Model\Question $currentQuestion)
    {
        $this->currentQuestion = $currentQuestion;
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
