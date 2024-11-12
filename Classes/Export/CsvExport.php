<?php

namespace RKW\RkwCheckup\Export;

use Madj2k\CoreExtended\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Answer;
use RKW\RkwCheckup\Domain\Model\Checkup;
use RKW\RkwCheckup\Domain\Model\Question;
use RKW\RkwCheckup\Domain\Model\ResultAnswer;
use RKW\RkwCheckup\Domain\Model\Section;
use RKW\RkwCheckup\Domain\Model\Step;
use RKW\RkwCheckup\Domain\Repository\ResultAnswerRepository;
use RKW\RkwCheckup\Domain\Repository\ResultRepository;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * CsvExport
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwCheckup
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CsvExport
{
    /**
     * @var resource $csv
     */
    private static $csv;

    /**
     * createCsv
     *
     * @param Checkup $checkup The checkup
     * @param string $separator The CSV file separator. Default is ";"
     * @return void
     * @throws Exception
     */
    public static function createCsv(Checkup $checkup, string $separator = ';')
    {
        $attachmentName = GeneralUtility::slugify($checkup->getTitle()) . '.csv';

        self::$csv = fopen('php://output', 'w');

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$attachmentName");
        header("Pragma: no-cache");

        // add reservation data
        self::addCheckupDataToCsv($checkup, $separator);

        fclose(self::$csv);
    }


    /**
     * addReservationDataToCsv
     *
     * @param Checkup $checkup
     * @param string $separator
     * @return void
     * @throws Exception
     */
    protected static function addCheckupDataToCsv(Checkup $checkup, string $separator)
    {

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ResultAnswerRepository $resultAnswerRepository */
        $resultAnswerRepository = $objectManager->get(ResultAnswerRepository::class);
        /** @var ResultRepository $resultRepository */
        $resultRepository = $objectManager->get(ResultRepository::class);

        /* ############## INITIAL ############## */
        // Add Check name and total results
        $checkData = [
            $checkup->getTitle(),
            'Σ ' . $resultRepository->getFinishedByCheck($checkup)->count(),
            date('d.m.Y'),
        ];
        fputcsv(self::$csv, $checkData, $separator);
        // empty line for usability
        fputcsv(self::$csv, [], $separator);

        // prepare columns (several column arrays needed for write calculation (calculate empty fields))
        $headingsSection = [
            'sectionTitle',
        ];
        $headingsStep = [
            'stepTitle',
        ];
        $headingsQuestion = [
            'questionTitle',
            'questionType',
            'mandatory',
        ];
        $headingsAnswer = [
            'answerText',
            'answerSum',
            'answerPercent',
        ];
        $headingsOther = [
            'additionalFreetext',
        ];

        // set headings
        fputcsv(self::$csv, array_merge($headingsSection, $headingsStep, $headingsQuestion, $headingsAnswer, $headingsOther), $separator);

        /* ############## SECTION ############## */
        /** @var Section $section */
        foreach ($checkup->getSection() as $section) {

            // initialize new row
            $row = [];

            $row[] = $section->getTitle();

            /* ############## STEP ############## */
            $stepIter = 0;
            /** @var Step $step */
            foreach ($section->getStep() as $step) {

                if ($stepIter > 0) {
                    // initialize new row
                    $row = [];

                    // !! keep structure columns empty
                    for ($i = 0; $i < count($headingsSection); $i++) {
                        $row[] = '';
                    }
                }

                $row[] = $step->getTitle();

                $stepIter++;

                /* ############## QUESTION ############## */
                $questionIter = 0;
                /** @var Question $question */
                foreach ($step->getQuestion() as $question) {

                    if ($questionIter > 0) {
                        // initialize new row
                        $row = [];

                        // !! keep structure columns empty
                        for ($i = 0; $i <= count(array_merge($headingsSection, $headingsStep)); $i++) {
                            $row[] = '';
                        }
                    }

                    $row[] = $question->getTitle();
                    $row[] = LocalizationUtility::translate(
                        'templates_backend_show.record_type.I.' . $question->getRecordType(),
                        'RkwCheckup'
                    );
                    $row[] = $question->getMandatory() ? LocalizationUtility::translate(
                        'templates_backend_show.mandatory.yes',
                        'RkwCheckup') : '';

                    $questionIter++;

                    /* ############## ANSWER ############## */
                    $answerIter = 0;
                    // Now every answer get a SINGLE ROW
                    /** @var Answer $answer */
                    foreach ($question->getAnswer() as $answer) {

                        if ($answerIter > 0) {
                            // initialize new row
                            $row = [];
                        }

                        if ($answerIter > 0) {
                            // !! keep structure columns empty
                            for ($i = 0; $i < count(array_merge($headingsSection, $headingsStep, $headingsQuestion)); $i++) {
                                $row[] = '';
                            }
                        }

                        $answerCount = $resultAnswerRepository->findByAnswer($answer)->count();
                        $questionAnswerTotal = $resultAnswerRepository->findByQuestion($question)->count();
                        $row[] = $answer->getTitle();
                        $row[] = $answerCount;
                        $row[] = number_format($answerCount / $questionAnswerTotal * 100, 2);


                        /* ############## ANSWER FREETEXT SPECIAL SOLUTION ############## */

                        // unfortunately EVERY additionalFreetextAnswer also needs a SINGLE ROW
                        // OR: put everything into one field
                        $freetextStringList = '';
                        $freetextAnswerIter = 0;
                        $freetextAnswerList = $resultAnswerRepository->findFreeTextInputAnswersByQuestion($question);
                        /** @var ResultAnswer $freetextAnswer */
                        foreach ($freetextAnswerList as $freetextAnswer) {

                           /*
                           if ($freetextAnswerIter > 0) {
                               // initialize new row
                               $row = [];

                               // !! keep structure + answer columns empty
                               for ($i = 0; $i < count(array_merge($headingsSection, $headingsStep, $headingsQuestion, $headingsAnswer)); $i++) {
                                   $row[] = '';
                               }
                           }
                           $row[] = $freetextAnswer->getFreeTextInput();
                           */


                            if ($freetextAnswerIter > 0) {
                                $freetextStringList .= ' ### ';
                            }
                            $freetextStringList .= $freetextAnswer->getFreeTextInput();

                            $freetextAnswerIter++;
                       }

                        if ($answerIter == 0) {
                            // Put freeText into CSV
                            $row[] = $freetextStringList;
                        }

                        fputcsv(self::$csv, $row, $separator);

                        $answerIter++;
                   }
               }
           }
       }
   }


}

