<?php

namespace RKW\RkwCheckup\Utility;

use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Result;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use RKW\RkwRegistration\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * Class CheckupUtility
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CheckupUtility
{

    /**
     * which step comes next?
     *
     * @param \RKW\RkwCheckup\Domain\Model\Checkup $checkup
     * @param \RKW\RkwCheckup\Domain\Model\Step $step
     * @return void
     */
    public static function nextStep ($checkup, $step)
    {

        // check
        /** @var \RKW\RkwCheckup\Domain\Model\Chapter $chapter */


        $chapterList = $checkup->getChapter();

        foreach ($chapterList as $chapter) {

            // iterate Steps until the given (current) $step is found. Then make a ->next() and return it

            //$chapter->getStep()->next();

            // @toDo: Abgleich Ausschlussfelder beachten, falls gesetzt bei "chapter" oder "step"

            // @toDo: Wie die Sache mit dem Zwischenergenis einbauen?
        }



    }

}