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

use RKW\RkwCheckup\Domain\Model\Checkup;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class ResultRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResultRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * get CheckResults that are completed by checkId and userId
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getFinishedByCheck(Checkup $checkup): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals("checkup", $checkup),
                $query->equals("finished", 1)
            )
        );

        return $query->execute();
    }


    /**
     * findByCheckupAlsoDeleted
     *
     * Find all results of check, also deleted
     *
     * @param Checkup $checkup
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByCheckupAlsoDeleted(Checkup $checkup): QueryResultInterface
    {

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIncludeDeleted(true);
        $query->getQuerySettings()->setIgnoreEnableFields(true);

        $query->matching(
            $query->equals('checkup', $checkup)
        );

        return $query->execute();
    }
}
