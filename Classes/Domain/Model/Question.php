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
 * Question
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Single choice or multiple choice
     *
     * @var string
     */
    protected $type = '';

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
     * sumTo100
     *
     * @var bool
     */
    protected $sumTo100 = false;

    /**
     * minCheck
     *
     * @var int
     */
    protected $minCheck = 0;

    /**
     * maxCheck
     *
     * @var string
     */
    protected $maxCheck = '';

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
     * answer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $answer = null;

    /**
     * hideCond
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer>
     */
    protected $hideCond = null;

    /**
     * step
     *
     * @var \RKW\RkwCheckup\Domain\Model\QuestionContainer
     */
    protected $questionContainer = null;

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
     * Returns the mandatory
     *
     * @return bool $mandatory
     */
    public function getMandatory()
    {
        return $this->mandatory;
    }

    /**
     * Sets the mandatory
     *
     * @param bool $mandatory
     * @return void
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * Returns the boolean state of mandatory
     *
     * @return bool
     */
    public function isMandatory()
    {
        return $this->mandatory;
    }

    /**
     * Returns the sumTo100
     *
     * @return bool $sumTo100
     */
    public function getSumTo100()
    {
        return $this->sumTo100;
    }

    /**
     * Sets the sumTo100
     *
     * @param bool $sumTo100
     * @return void
     */
    public function setSumTo100($sumTo100)
    {
        $this->sumTo100 = $sumTo100;
    }

    /**
     * Returns the boolean state of sumTo100
     *
     * @return bool
     */
    public function isSumTo100()
    {
        return $this->sumTo100;
    }

    /**
     * Returns the minCheck
     *
     * @return int $minCheck
     */
    public function getMinCheck()
    {
        return $this->minCheck;
    }

    /**
     * Sets the minCheck
     *
     * @param int $minCheck
     * @return void
     */
    public function setMinCheck($minCheck)
    {
        $this->minCheck = $minCheck;
    }

    /**
     * Returns the maxCheck
     *
     * @return string $maxCheck
     */
    public function getMaxCheck()
    {
        return $this->maxCheck;
    }

    /**
     * Sets the maxCheck
     *
     * @param string $maxCheck
     * @return void
     */
    public function setMaxCheck($maxCheck)
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
     * Adds a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answer
     * @return void
     */
    public function addAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answer)
    {
        $this->answer->attach($answer);
    }

    /**
     * Removes a Answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answerToRemove)
    {
        $this->answer->detach($answerToRemove);
    }

    /**
     * Returns the answer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Answer> $answer
     * @return void
     */
    public function setAnswer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * Returns the questionContainer
     *
     * @return \RKW\RkwCheckup\Domain\Model\QuestionContainer questionContainer
     */
    public function getQuestionContainer()
    {
        return $this->questionContainer;
    }

    /**
     * Sets the questionContainer
     *
     * @param \RKW\RkwCheckup\Domain\Model\QuestionContainer $questionContainer
     * @return void
     */
    public function setQuestionContainer(\RKW\RkwCheckup\Domain\Model\QuestionContainer $questionContainer)
    {
        $this->questionContainer = $questionContainer;
    }
}
