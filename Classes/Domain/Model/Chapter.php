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
 * Chapter
 */
class Chapter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * step
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
     * interimResult
     *
     * @var \RKW\RkwCheckup\Domain\Model\InterimResult
     */
    protected $interimResult = null;

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
        $this->step = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the interimResult
     *
     * @return \RKW\RkwCheckup\Domain\Model\InterimResult $interimResult
     */
    public function getInterimResult()
    {
        return $this->interimResult;
    }

    /**
     * Sets the interimResult
     *
     * @param \RKW\RkwCheckup\Domain\Model\InterimResult $interimResult
     * @return void
     */
    public function setInterimResult(\RKW\RkwCheckup\Domain\Model\InterimResult $interimResult)
    {
        $this->interimResult = $interimResult;
    }
}
