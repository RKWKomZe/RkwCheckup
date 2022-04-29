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
 * Class AnswerRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AnswerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * findByQuestionAlsoDeleted
     *
     * Find all questions of a step, also deleted
     *
     * @param Question $question
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByQuestionAlsoDeleted(Question $question)
    {

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIncludeDeleted(true);
        $query->getQuerySettings()->setIgnoreEnableFields(true);

        $query->matching(
            $query->equals('question', $question)
        );

        return $query->execute();
    }

}
