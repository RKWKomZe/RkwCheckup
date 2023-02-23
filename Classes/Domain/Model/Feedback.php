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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Class Feedback
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Feedback extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected int $recordType = 0;


    /**
     * @var string
     */
    protected string $title = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?FileReference $image = null;


    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?FileReference $file = null;


    /**
     * @var string
     */
    protected string $link = '';


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
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null $image
     */
    public function getImage():? FileReference
    {
        return $this->image;
    }


    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(FileReference $image): void
    {
        $this->image = $image;
    }


    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     */
    public function getFile():? FileReference
    {
        return $this->file;
    }


    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(FileReference $file): void
    {
        $this->file = $file;
    }


    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink(): string
    {
        return $this->link;
    }


    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * Returns the recordType
     *
     * @return int $recordType
     */
    public function getRecordType(): int
    {
        return $this->recordType;
    }


    /**
     * Sets the recordType
     *
     * @param int $recordType
     * @return void
     */
    public function setRecordType(int $recordType): void
    {
        $this->recordType = $recordType;
    }
}
