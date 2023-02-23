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
 * Check
 */
class Checkup extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected int $crdate = 0;


    /**
     * @var int
     */
    protected int $tstamp = 0;


    /**
     * section
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $section = null;


    /**
     * @var string
     */
    protected string $title = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var string
     */
    protected string $resultIntro = '';


    /**
     * @var \RKW\RkwCheckup\Domain\Model\Question|null
     */
    protected ?Question $contextQuestion = null;


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
     * Returns the crdate
     *
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }


    /**
     * Sets the crdate
     *
     * @param int $crdate
     * @return void
     */
    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }


    /**
     * Returns the tstamp
     *
     * @return int $tstamp
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }


    /**
     * Sets the tstamp
     *
     * @param int $tstamp
     * @return void
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
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
     * @return string
     */
    public function getResultIntro(): string
    {
        return $this->resultIntro;
    }


    /**
     * @param string $resultIntro
     */
    public function setResultIntro(string $resultIntro): void
    {
        $this->resultIntro = $resultIntro;
    }


    /**
     * Adds a Section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @return void
     * @api
     */
    public function addSection(Section $section): void
    {
        $this->section->attach($section);
    }


    /**
     * Removes a Section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $sectionToRemove The Section to be removed
     * @return void
     * @api
     */
    public function removeSection(Section $sectionToRemove): void
    {
        $this->section->detach($sectionToRemove);
    }


    /**
     * Returns the section
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section>
     * @api
     */
    public function getSection(): ObjectStorage
    {
        return $this->section;
    }


    /**
     * Sets the section
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section> $section
     * @return void
     * @api
     */
    public function setSection(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $section): void
    {
        $this->section = $section;
    }


    /**
     * Returns the contextQuestion
     *
     * @return \RKW\RkwCheckup\Domain\Model\Question|null $contextQuestion
     */
    public function getContextQuestion():? Question
    {
        return $this->contextQuestion;
    }


    /**
     * Sets the contextQuestion
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $contextQuestion
     * @return void
     */
    public function setContextQuestion(\RKW\RkwCheckup\Domain\Model\Question $contextQuestion): void
    {
        $this->contextQuestion = $contextQuestion;
    }
}
