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
 * QuestionContainer
 */
class QuestionContainer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * questionType1
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     * @cascade remove
     */
    protected $questionType1 = null;

    /**
     * questionType2
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     * @cascade remove
     */
    protected $questionType2 = null;

    /**
     * questionType3
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     * @cascade remove
     */
    protected $questionType3 = null;

    /**
     * questionType4
     *
     * @var \RKW\RkwCheckup\Domain\Model\Question
     * @cascade remove
     */
    protected $questionType4 = null;

    /**
     * step
     *
     * @var \RKW\RkwCheckup\Domain\Model\Step
     */
    protected $step = null;


    /**
     * Service function to GET the Question, no matter which type the question is
     * @return \RKW\RkwCheckup\Domain\Model\Question
     */
    public function getQuestion()
    {
        $i = 0;
        do {
            $i++;
            $functionNameGetter = 'getQuestionType' . $i;
        } while (
            method_exists($this, $functionNameGetter)
            && !$this->$functionNameGetter() instanceof Question
        );

        return $this->$functionNameGetter();
    }

    /**
     * Service function to SET the Question, no matter which type the question is
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @throws \Exception
     */
    public function setQuestion(Question $question): void
    {
        $propertyName = 'questionType' . $question->getType();

        if (!property_exists($this, $propertyName)) {
            throw new \Exception('No or not existing question type given. Set the type or use specific setter function.', 1639494034);
        }

        $this->$propertyName = $question;
    }

    /**
    * @return \RKW\RkwCheckup\Domain\Model\Question
    */
    public function getQuestionType1()
    {
        return $this->questionType1;
    }

    /**
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionType1
     */
    public function setQuestionType1(Question $questionType1)
    {
        $this->questionType1 = $questionType1;
    }

    /**
     * @return \RKW\RkwCheckup\Domain\Model\Question
     */
    public function getQuestionType2()
    {
        return $this->questionType2;
    }

    /**
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionType2
     */
    public function setQuestionType2(Question $questionType2)
    {
        $this->questionType2 = $questionType2;
    }

    /**
     * @return \RKW\RkwCheckup\Domain\Model\Question
     */
    public function getQuestionType3()
    {
        return $this->questionType3;
    }

    /**
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionType3
     */
    public function setQuestionType3(Question $questionType3)
    {
        $this->questionType3 = $questionType3;
    }

    /**
     * @return \RKW\RkwCheckup\Domain\Model\Question
     */
    public function getQuestionType4(): Question
    {
        return $this->questionType4;
    }

    /**
     * @param \RKW\RkwCheckup\Domain\Model\Question $questionType4
     */
    public function setQuestionType4(Question $questionType4)
    {
        $this->questionType4 = $questionType4;
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


}
