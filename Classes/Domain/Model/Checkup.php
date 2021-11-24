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
 * Check
 */
class Checkup extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * section
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section>
     * @cascade remove
     */
    protected $section = null;

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
     * contextQuestion
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     */
    protected $contextQuestion = null;

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
     * Adds a Section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @return void
     */
    public function addSection(\RKW\RkwCheckup\Domain\Model\Section $section)
    {
        $this->section->attach($section);
    }

    /**
     * Removes a Section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $sectionToRemove The Section to be removed
     * @return void
     */
    public function removeSection(\RKW\RkwCheckup\Domain\Model\Section $sectionToRemove)
    {
        $this->section->detach($sectionToRemove);
    }

    /**
     * Returns the section
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section> $section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Sets the section
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Section> $section
     * @return void
     */
    public function setSection(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $section)
    {
        $this->section = $section;
    }

    /**
     * Returns the contextQuestion
     *
     * @return \RKW\RkwCheckup\Domain\Model\Question $contextQuestion
     */
    public function getContextQuestion()
    {
        return $this->contextQuestion;
    }

    /**
     * Sets the contextQuestion
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $contextQuestion
     * @return void
     */
    public function setContextQuestion(\RKW\RkwCheckup\Domain\Model\Question $contextQuestion)
    {
        $this->contextQuestion = $contextQuestion;
    }
}
