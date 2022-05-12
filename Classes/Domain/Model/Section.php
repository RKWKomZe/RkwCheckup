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
 * Class Section
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Section extends AbstractCheckupContents
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
    protected $step;
    

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
     * checkup
     *
     * @var \RKW\RkwCheckup\Domain\Model\Checkup
     */
    protected $checkup;

    
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
     * Adds a Step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     * @api
     */
    public function addStep(\RKW\RkwCheckup\Domain\Model\Step $step): void
    {
        $this->step->attach($step);
    }
    

    /**
     * Removes a Step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $stepToRemove The Step to be removed
     * @return void
     * @api
     */
    public function removeStep(\RKW\RkwCheckup\Domain\Model\Step $stepToRemove): void
    {
        $this->step->detach($stepToRemove);
    }

    
    /**
     * Returns the step
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Step> $step
     * @api
     */
    public function getStep(): ObjectStorage
    {
        return $this->step;
    }

    
    /**
     * Sets the step
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Step> $step
     * @return void
     * @api
     */
    public function setStep(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $step): void
    {
        $this->step = $step;
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
     * Returns the checkup
     *
     * @return \RKW\RkwCheckup\Domain\Model\Checkup|null $checkup
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
    public function setCheckup(\RKW\RkwCheckup\Domain\Model\Checkup $checkup): void
    {
        $this->checkup = $checkup;
    }
}
