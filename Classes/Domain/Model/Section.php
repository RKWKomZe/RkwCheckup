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
 * Section
 */
class Section extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
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
     * hideText
     *
     * @var bool
     */
    protected $hideText = false;

    /**
     * section
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Step>
     * @cascade remove
     */
    protected $step = null;

    /**
     * hideCond
     *
     * @var \RKW\RkwCheckup\Domain\Model\Answer
     */
    protected $hideCond = null;

    /**
     * checkup
     *
     * @var \RKW\RkwCheckup\Domain\Model\Checkup
     */
    protected $checkup = null;

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
        $this->section = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Adds a Step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function addStep(\RKW\RkwCheckup\Domain\Model\Step $step)
    {
        $this->step->attach($step);
    }

    /**
     * Removes a Step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $stepToRemove The Step to be removed
     * @return void
     */
    public function removeStep(\RKW\RkwCheckup\Domain\Model\Step $stepToRemove)
    {
        $this->step->detach($stepToRemove);
    }

    /**
     * Returns the step
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Step> $step
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Sets the step
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Step> $step
     * @return void
     */
    public function setStep(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $step)
    {
        $this->step = $step;
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
}
