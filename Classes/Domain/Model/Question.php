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
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Question extends AbstractCheckupContents
{

    /**
     * @var int
     */
    protected int $recordType = 1;


    /**
     * @var string
     */
    protected string $title = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var bool
     */
    protected bool $mandatory = false;


    /**
     * @var bool
     */
    protected bool $invertFeedback = false;


    /**
     * @var bool
     */
    protected bool $allowTextInput = false;


    /**
     * @var string
     */
    protected string $titleTextInput = '';


    /**
     * @var int
     */
    protected int $minCheck = 0;


    /**
     * @var int
     */
    protected int $maxCheck = 0;


    /**
     * @var string
     */
    protected string $scaleLeft = '';


    /**
     * @var string
     */
    protected string $scaleRight = '';


    /**
     * @var int
     */
    protected int $scaleMax = 3;


    /**
     * feedback
     *
     * @var \RKW\RkwCheckup\Domain\Model\Feedback|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?Feedback $feedback = null;


    /**
     * answer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>|null
     */
    protected ?ObjectStorage $answer = null;


    /**
     * hideCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>|null
     */
    protected ?ObjectStorage $hideCond = null;


    /**
     * visibleCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>|null
     */
    protected ?ObjectStorage $visibleCond = null;


    /**
     * step
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step|null
     */
    protected ?Step $step= null;


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
        $this->answer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->hideCond = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->visibleCond = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Returns the recordType
     *
     * @return string
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
     * @return string
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
     * @return string
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
     * @return bool
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
     * @return bool
     */
    public function getInvertFeedback(): bool
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
    public function getAllowTextInput(): bool
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
     * @return int
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
     * @return int
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
    public function getFeedback():? Feedback
    {
        return $this->feedback;
    }


    /**
     * Sets the feedback
     *
     * @param \RKW\RkwCheckup\Domain\Model\Feedback $feedback
     * @return void
     */
    public function setFeedback(Feedback $feedback): void
    {
        $this->feedback = $feedback;
    }


    /**
     * Adds an Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answer
     * @return void
     * @api
     */
    public function addAnswer(Answer $answer): void
    {
        $this->answer->attach($answer);
    }


    /**
     * Removes an Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     * @api
     */
    public function removeAnswer(Answer $answerToRemove): void
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
    public function setAnswer(ObjectStorage $answer): void
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
    public function addHideCond(Answer $hideCond): void
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
    public function removeHideCond(Answer $hideCond): void
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
    public function setHideCond(ObjectStorage $hideCond): void
    {
        $this->hideCond = $hideCond;
    }


    /**
     * Adds a visibleCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $visibleCond
     * @return void
     */
    public function addVisibleCond(Answer $visibleCond)
    {
        $this->visibleCond->attach($visibleCond);
    }


    /**
     * Removes a visibleCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $visibleCondToRemove The visibleCond to be removed
     * @return void
     * @api
     */
    public function removeVisibleCond(Answer $visibleCond): void
    {
        $this->visibleCond->detach($visibleCond);
    }


    /**
     * Returns the visibleCond
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $visibleCond
     * @api
     */
    public function getVisibleCond(): ObjectStorage
    {
        return $this->visibleCond;
    }


    /**
     * Sets the visibleCond
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $visibleCond
     * @return void
     * @api
     */
    public function setVisibleCond(ObjectStorage $visibleCond): void
    {
        $this->visibleCond = $visibleCond;
    }


    /**
     * Returns the step
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step|null step
     */
    public function getStep():? Step
    {
        return $this->step;
    }


    /**
     * Sets the step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function setStep(Step $step): void
    {
        $this->step = $step;
    }
}
