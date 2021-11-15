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
     * chapter
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Chapter>
     * @cascade remove
     */
    protected $chapter = null;

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
        $this->chapter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Adds a Chapter
     *
     * @param \RKW\RkwCheckup\Domain\Model\Chapter $chapter
     * @return void
     */
    public function addChapter(\RKW\RkwCheckup\Domain\Model\Chapter $chapter)
    {
        $this->chapter->attach($chapter);
    }

    /**
     * Removes a Chapter
     *
     * @param \RKW\RkwCheckup\Domain\Model\Chapter $chapterToRemove The Chapter to be removed
     * @return void
     */
    public function removeChapter(\RKW\RkwCheckup\Domain\Model\Chapter $chapterToRemove)
    {
        $this->chapter->detach($chapterToRemove);
    }

    /**
     * Returns the chapter
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Chapter> $chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Sets the chapter
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwCheckup\Domain\Model\Chapter> $chapter
     * @return void
     */
    public function setChapter(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $chapter)
    {
        $this->chapter = $chapter;
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
