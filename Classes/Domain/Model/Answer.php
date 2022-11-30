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

/**
 * Class Answer
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * feedback
     *
     * @var \RKW\RkwCheckup\Domain\Model\Feedback
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $feedback;


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
    public function setTitle(string $title)
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
    public function setDescription(string $description)
    {
        $this->description = $description;
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


}
