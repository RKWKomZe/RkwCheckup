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

/**
 * Step
 */
class Step extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * hideText
     *
     * @var bool
     */
    protected $hideText = false;

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
     * question
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Question>
     * @cascade remove
     */
    protected $question = null;

    /**
     * hideCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $hideCond = null;

    /**
     * stepFeedback
     *
     * @var \RKW\RkwCheckup\Domain\Model\StepFeedback
     */
    protected $stepFeedback = null;

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
        $this->question = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->hideCond = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a hideCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCond
     * @return void
     */
    public function addHideCond(\RKW\RkwCheckup\Domain\Model\Answer $hideCond)
    {
        $this->hideCond->attach($hideCond);
    }

    /**
     * Removes a hideCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCondToRemove The hideCond to be removed
     * @return void
     */
    public function removeHideCond(\RKW\RkwCheckup\Domain\Model\Answer $hideCond)
    {
        $this->hideCond->detach($hideCond);
    }

    /**
     * Returns the hideCond
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $hideCond
     */
    public function getHideCond()
    {
        return $this->hideCond;
    }

    /**
     * Sets the hideCond
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $hideCond
     * @return void
     */
    public function setHideCond(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $hideCond)
    {
        $this->hideCond = $hideCond;
    }

    /**
     * Returns the hideText
     *
     * @return bool $hideText
     */
    public function getHideText()
    {
        return $this->hideText;
    }

    /**
     * Sets the hideText
     *
     * @param bool $hideText
     * @return void
     */
    public function setHideText($hideText)
    {
        $this->hideText = $hideText;
    }

    /**
     * Returns the boolean state of hideText
     *
     * @return bool
     */
    public function isHideText()
    {
        return $this->hideText;
    }

    /**
     * Returns the stepFeedback
     *
     * @return \RKW\RkwCheckup\Domain\Model\StepFeedback $stepFeedback
     */
    public function getStepFeedback()
    {
        return $this->stepFeedback;
    }

    /**
     * Sets the stepFeedback
     *
     * @param \RKW\RkwCheckup\Domain\Model\StepFeedback $stepFeedback
     * @return void
     */
    public function setStepFeedback(\RKW\RkwCheckup\Domain\Model\StepFeedback $stepFeedback)
    {
        $this->stepFeedback = $stepFeedback;
    }

    /**
     * Adds a Question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(\RKW\RkwCheckup\Domain\Model\Question $question)
    {
        $this->question->attach($question);
    }

    /**
     * Removes a Question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(\RKW\RkwCheckup\Domain\Model\Question $questionToRemove)
    {
        $this->question->detach($questionToRemove);
    }

    /**
     * Returns the Question
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Question> $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the Question
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Question> $question
     * @return void
     */
    public function setQuestion(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $question)
    {
        $this->question = $question;
    }
}
