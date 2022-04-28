<?php
namespace RKW\RkwCheckup\Domain\Repository;

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

use RKW\RkwCheckup\Domain\Model\Question;

/**
 * Class ResultAnswerRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultAnswerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * get answers of specific question with FreeTextInput
     *
     * @param \RKW\RkwCheckup\Domain\Model\Question $question
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFreeTextInputAnswersByQuestion(Question $question)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals("question", $question->getUid()),
                $query->equals("answer", 0)
            )
        );

        return $query->execute();
    }
}
