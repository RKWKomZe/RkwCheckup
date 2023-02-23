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
 * Class ResultAnswer
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultAnswer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $freeNumericInput = 0;


    /**
     * @var string
     */
    protected string $freeTextInput = '';


    /**
     * answer
     *
     * @var \RKW\RkwCheckup\Domain\Model\Answer|null
     */
    protected ?Answer $answer = null;


    /**
     * question
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question|null
     */
    protected ?Question $question = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Model\Step|null
     */
    protected ?Step $step = null;


    /**
     * @var \RKW\RkwCheckup\Domain\Model\Section|null
     */
    protected ?Section $section = null;


    /**
     * @return int
     */
    public function getFreeNumericInput(): int
    {
        return $this->freeNumericInput;
    }


    /**
     * @param int $freeNumericInput
     */
    public function setFreeNumericInput(int $freeNumericInput): void
    {
        $this->freeNumericInput = $freeNumericInput;
    }


    /**
     * @return string
     */
    public function getFreeTextInput(): string
    {
        return $this->freeTextInput;
    }

    /**
     * @param string $freeTextInput
     */
    public function setFreeTextInput(string $freeTextInput): void
    {
        $this->freeTextInput = $freeTextInput;
    }


    /**
     * Returns the answer
     *
     * @return \RKW\RkwCheckup\Domain\Model\Answer|null $answer
     */
    public function getAnswer():? Answer
    {
        return $this->answer;
    }


    /**
     * Sets the answer
     *
     * @param \RKW\RkwCheckup\Domain\Model\Answer $answer
     * @return void
     */
    public function setAnswer(\RKW\RkwCheckup\Domain\Model\Answer $answer): void
    {
        $this->answer = $answer;
    }


    /**
     * Returns the question
     *
     * @return \RKW\RkwCheckup\Domain\Model\Question|null $question
     */
    public function getQuestion():? Question
    {
        return $this->question;
    }


    /**
     * Sets the question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\RKW\RkwCheckup\Domain\Model\Question $question): void
    {
        $this->question = $question;
    }


    /**
     * Returns the step
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step|null step
     */
    public function getStep():? Step
    {
        return $this->step;
    }


    /**
     * Sets the step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function setStep(\RKW\RkwCheckup\Domain\Model\Step $step): void
    {
        $this->step = $step;
    }


    /**
     * Returns the section
     *
     * @return \RKW\RkwCheckup\Domain\Model\Section|null section
     */
    public function getSection():? Section
    {
        return $this->section;
    }


    /**
     * Sets the section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @return void
     */
    public function setSection(\RKW\RkwCheckup\Domain\Model\Section $section): void
    {
        $this->section = $section;
    }
}
