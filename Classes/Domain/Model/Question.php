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
     * answer
     *
     * @var \RKW\RkwCheckup\Domain\Model\Answer
     */
    protected $answer = null;

    /**
     * hideCond
     *
     * @var \RKW\RkwCheckup\Domain\Model\Answer
     */
    protected $hideCond = null;

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
     * Returns the answer
     *
     * @return \RKW\RkwCheckup\Domain\Model\Answer $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answer
     * @return void
     */
    public function setAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answer)
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
     * Returns the hideCond
     *
     * @return \RKW\RkwCheckup\Domain\Model\Answer $hideCond
     */
    public function getHideCond()
    {
        return $this->hideCond;
    }

    /**
     * Sets the hideCond
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $hideCond
     * @return void
     */
    public function setHideCond(\RKW\RkwCheckup\Domain\Model\Answer $hideCond)
    {
        $this->hideCond = $hideCond;
    }
}
