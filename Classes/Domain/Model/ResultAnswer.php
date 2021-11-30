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
 * ResultAnswer
 */
class ResultAnswer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * answer
     *
     * @var \RKW\RkwCheckup\Domain\Model\Answer
     */
    protected $answer = null;

    /**
     * question
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     */
    protected $question = null;

    /**
     * step
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $step = null;

    /**
     * section
     *
     * @var \RKW\RkwCheckup\Domain\Model\Section
     */
    protected $section = null;

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
     * Returns the question
     *
     * @return \RKW\RkwCheckup\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\RKW\RkwCheckup\Domain\Model\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Returns the step
     *
     * @return \RKW\RkwCheckup\Domain\Model\Step step
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Sets the step
     *
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public function setStep(\RKW\RkwCheckup\Domain\Model\Step $step)
    {
        $this->step = $step;
    }

    /**
     * Returns the section
     *
     * @return \RKW\RkwCheckup\Domain\Model\Section section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Sets the section
     *
     * @param \RKW\RkwCheckup\Domain\Model\Section $section
     * @return void
     */
    public function setSection(\RKW\RkwCheckup\Domain\Model\Section $section)
    {
        $this->section = $section;
    }
}
