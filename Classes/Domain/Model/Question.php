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
 * Class Question
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Question extends AbstractCheckupContents
{
    
    /**
     * type
     *
     * @var int
     */
    protected $recordType = 1;

    
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    
    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    
    /**
     * mandatory
     *
     * @var bool
     */
    protected $mandatory = false;

    
    /**
     * invertFeedback
     *
     * @var bool
     */
    protected $invertFeedback = false;


    /**
     * allowTextInput
     *
     * @var bool
     */
    protected $allowTextInput = false;

    /**
     * titleTextInput
     *
     * @var string
     */
    protected $titleTextInput = '';

    
    /**
     * minCheck
     *
     * @var int
     */
    protected $minCheck = 0;

    
    /**
     * maxCheck
     *
     * @var int
     */
    protected $maxCheck = 0;

    
    /**
     * scaleLeft
     *
     * @var string
     */
    protected $scaleLeft = '';

    
    /**
     * scaleRight
     *
     * @var string
     */
    protected $scaleRight = '';

    
    /**
     * scaleMax
     *
     * @var string
     */
    protected $scaleMax = 3;


    /**
     * feedback
     *
     * @var \RKW\RkwCheckup\Domain\Model\Feedback
     * @cascade remove
     */
    protected $feedback;


    /**
     * answer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $answer;

    
    /**
     * hideCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $hideCond;

    
    /**
     * step
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $step;

    
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
        $this->answer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->hideCond = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Returns the recordType
     *
     * @return string $recordType
     */
    public function getRecordType(): string
    {
        return $this->recordType;
    }


    /**
     * Sets the recordType
     *
     * @param string $recordType
     * @return void
     */
    public function setRecordType(string $recordType): void
    {
        $this->recordType = $recordType;
    }

    
    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    
    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    
    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    
    /**
     * Returns the mandatory
     *
     * @return bool $mandatory
     */
    public function getMandatory(): bool
    {
        return $this->mandatory;
    }

    
    /**
     * Sets the mandatory
     *
     * @param bool $mandatory
     * @return void
     */
    public function setMandatory(bool $mandatory): bool
    {
        $this->mandatory = $mandatory;
    }

    
    /**
     * Returns the boolean state of mandatory
     *
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    
    /**
     * @return bool
     */
    public function isInvertFeedback(): bool
    {
        return $this->invertFeedback;
    }

    
    /**
     * @param bool $invertFeedback
     */
    public function setInvertFeedback(bool $invertFeedback): void
    {
        $this->invertFeedback = $invertFeedback;
    }


    /**
     * @return bool
     */
    public function isAllowTextInput(): bool
    {
        return $this->allowTextInput;
    }


    /**
     * @param bool $allowTextInput
     */
    public function setAllowTextInput(bool $allowTextInput): void
    {
        $this->allowTextInput = $allowTextInput;
    }


    /**
     * @return string
     */
    public function getTitleTextInput(): string
    {
        return $this->titleTextInput;
    }


    /**
     * @param string $titleTextInput
     */
    public function setTitleTextInput(string $titleTextInput): void
    {
        $this->titleTextInput = $titleTextInput;
    }


    
    /**
     * Returns the minCheck
     *
     * @return int $minCheck
     */
    public function getMinCheck(): int
    {
        return $this->minCheck;
    }

    
    /**
     * Sets the minCheck
     *
     * @param int $minCheck
     * @return void
     */
    public function setMinCheck(int $minCheck): void
    {
        $this->minCheck = $minCheck;
    }

    
    /**
     * Returns the maxCheck
     *
     * @return int $maxCheck
     */
    public function getMaxCheck(): int
    {
        return $this->maxCheck;
    }

    
    /**
     * Sets the maxCheck
     *
     * @param int $maxCheck
     * @return void
     */
    public function setMaxCheck(int $maxCheck): void
    {
        $this->maxCheck = $maxCheck;
    }
    

    /**
     * @return string
     */
    public function getScaleLeft(): string
    {
        return $this->scaleLeft;
    }

    
    /**
     * @param string $scaleLeft
     */
    public function setScaleLeft(string $scaleLeft): void
    {
        $this->scaleLeft = $scaleLeft;
    }

    
    /**
     * @return string
     */
    public function getScaleRight(): string
    {
        return $this->scaleRight;
    }

    
    /**
     * @param string $scaleRight
     */
    public function setScaleRight(string $scaleRight): void
    {
        $this->scaleRight = $scaleRight;
    }

    
    /**
     * Returns the scaleMax
     *
     * @return int $scaleMax
     */
    public function getScaleMax(): int
    {
        return $this->scaleMax;
    }


    /**
     * Sets the scaleMax
     *
     * @param int $scaleMax
     * @return void
     */
    public function setScaleMax(int $scaleMax): void
    {
        $this->scaleMax = $scaleMax;
    }


    /**
     * Returns the feedback
     *
     * @return \RKW\RkwCheckup\Domain\Model\Feedback|null $feedback
     */
    public function getFeedback()
    {
        return $this->feedback;
    }


    /**
     * Sets the feedback
     *
     * @param \RKW\RkwCheckup\Domain\Model\Feedback $feedback
     * @return void
     */
    public function setFeedback(\RKW\RkwCheckup\Domain\Model\Feedback $feedback): void
    {
        $this->feedback = $feedback;
    }
    
    /**
     * Adds a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answer
     * @return void
     * @api
     */
    public function addAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answer): void
    {
        $this->answer->attach($answer);
    }

    
    /**
     * Removes a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     * @api
     */
    public function removeAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answerToRemove): void
    {
        $this->answer->detach($answerToRemove);
    }

    
    /**
     * Returns the answer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $answer
     * @api
     */
    public function getAnswer(): ObjectStorage
    {
        return $this->answer;
    }

    
    /**
     * Sets the answer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $answer
     * @return void
     */
    public function setAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answer): void
    {
        $this->answer = $answer;
    }

    
    
    /**
     * Adds a hideCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCond
     * @return void
     * @api
     */
    public function addHideCond(\RKW\RkwCheckup\Domain\Model\Answer $hideCond): void
    {
        $this->hideCond->attach($hideCond);
    }

    /**
     * Removes a hideCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCond The hideCond to be removed
     * @return void
     * @api
     */
    public function removeHideCond(\RKW\RkwCheckup\Domain\Model\Answer $hideCond): void
    {
        $this->hideCond->detach($hideCond);
    }

    
    /**
     * Returns the hideCond
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $hideCond
     */
    public function getHideCond(): ObjectStorage
    {
        return $this->hideCond;
    }

    
    /**
     * Sets the hideCond
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $hideCond
     * @return void
     */
    public function setHideCond(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $hideCond): void
    {
        $this->hideCond = $hideCond;
    }

    
    /**
     * Returns the step
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step|null step
     */
    public function getStep()
    {
        return $this->step;
    }
    

    /**
     * Sets the step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function setStep(\RKW\RkwCheckup\Domain\Model\Step $step): void
    {
        $this->step = $step;
    }
}
