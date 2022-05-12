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
 * Class Step
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Step extends AbstractCheckupContents
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
    protected $question;

    
    /**
     * hideCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $hideCond;


    /**
     * visibleCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $visibleCond;

    
    /**
     * feedback
     *
     * @var \RKW\RkwCheckup\Domain\Model\Feedback
     * @cascade remove
     */
    protected $feedback;

    
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
        $this->visibleCond = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCondToRemove The hideCond to be removed
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
     * @api
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
     * @api
     */
    public function setHideCond(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $hideCond): void
    {
        $this->hideCond = $hideCond;
    }


    /**
     * Adds a visibleCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $visibleCond
     * @return void
     */
    public function addVisibleCond(\RKW\RkwCheckup\Domain\Model\Answer $visibleCond)
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
    public function removeVisibleCond(\RKW\RkwCheckup\Domain\Model\Answer $visibleCond): void
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
    public function setVisibleCond(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $visibleCond): void
    {
        $this->visibleCond = $visibleCond;
    }

    
    /**
     * Returns the hideText
     *
     * @return bool $hideText
     */
    public function getHideText(): bool
    {
        return $this->hideText;
    }
    

    /**
     * Sets the hideText
     *
     * @param bool $hideText
     * @return void
     */
    public function setHideText(bool $hideText): void
    {
        $this->hideText = $hideText;
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
     * Adds a Question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return void
     * @api
     */
    public function addQuestion(\RKW\RkwCheckup\Domain\Model\Question $question): void
    {
        $this->question->attach($question);
    }

    
    /**
     * Removes a Question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     * @api
     */
    public function removeQuestion(\RKW\RkwCheckup\Domain\Model\Question $questionToRemove): void
    {
        $this->question->detach($questionToRemove);
    }
    

    /**
     * Returns the Question
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Question> $question
     * @api
     */
    public function getQuestion(): ObjectStorage
    {
        return $this->question;
    }
    

    /**
     * Sets the Question
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Question> $question
     * @return void
     * @api
     */
    public function setQuestion(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $question): void
    {
        $this->question = $question;
    }
}
