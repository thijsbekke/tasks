<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 1-1-2019
 * Time: 17:59
 */
require_once "weare.php";


$store = new TokenCache();
$token = $store->getAccessToken();

if (empty($token)) {
    header('Location: ' . env('OAUTH_SIGNIN_URI'));
    die();
}


$outlook = new OutlookController(1);
$user = $outlook->me();

$task = new Task();
$currentOpenTasks = $task->count();

$resultYear = Database::getInstance()->fetchRowMany("
    SELECT statistics.*, WEEK(statistics.datetime, 3) AS 'week'
    FROM statistics
    INNER JOIN (
        SELECT MAX(statistics.datetime) AS 'datetime', WEEK(statistics.datetime, 3) AS 'week'
        FROM statistics
        GROUP BY WEEK(statistics.datetime, 3)
    ) a
    ON a.datetime = statistics.`datetime`
    ORDER BY statistics.`datetime`
");

$dataYear = [];
foreach($resultYear as $result) {
    $dataYear[$result['week']] = "'" . $result['total_open_tasks'] . "'";
}

$resultsWeek = Database::getInstance()->fetchRowMany("
    SELECT DATE_FORMAT(a.datetime, '%d-%m-%Y') AS 'datetime', total_open_tasks 
    FROM statistics
    INNER JOIN (
        SELECT MAX(statistics.datetime) AS 'datetime', WEEK(statistics.datetime, 3) AS 'week'
        FROM statistics
        WHERE 1
                AND DATE(statistics.datetime) > CURDATE() - INTERVAL 1 YEAR
        GROUP BY YEAR(statistics.datetime), MONTH(statistics.datetime), DAY(statistics.datetime)
    ) a
    ON a.datetime = statistics.`datetime`
    ORDER BY statistics.`datetime`
");

$dataWeek = [];
foreach($resultsWeek as $result) {
    $dataWeek[$result['datetime']] = "'" . $result['total_open_tasks'] . "'";
}


$resultsDay = Database::getInstance()->fetchRowMany("
    SELECT DATE_FORMAT(a.datetime, '%d-%m-%Y %H:00') AS 'datetime', total_open_tasks 
    FROM statistics
    INNER JOIN (
        SELECT MAX(statistics.datetime) AS 'datetime', WEEK(statistics.datetime, 3) AS 'week'
        FROM statistics
        WHERE 1
                AND DATE(statistics.datetime) > CURDATE() - INTERVAL 5 DAY
        GROUP BY YEAR(statistics.datetime), MONTH(statistics.datetime), DAY(statistics.datetime), HOUR(statistics.datetime)
    ) a
    ON a.datetime = statistics.`datetime`
    ORDER BY statistics.`datetime`;
");

$dataDay = [];
foreach($resultsDay as $result) {
    $dataDay[$result['datetime']] = "'" . $result['total_open_tasks'] . "'";
}

$results = Database::getInstance()->fetchRow("
  SELECT MAX(statistics.datetime) AS 'datetime' FROM statistics
");

$lastChecked = new DateTime($results['datetime']);

$resultStartWeek = Database::getInstance()->fetchRow("
    SELECT statistics.* FROM statistics
    WHERE 1
      AND WEEK(statistics.datetime, 3) = WEEK(NOW(), 3)
    ORDER BY statistics.`datetime` ASC
    LIMIT 1
");

//uitrekenen: gemiddelde per week

//Hoeveel weken nog ?

//Hoeveel weken hebben we
/**
 * In ISO-8601 specification, it says that December 28th is always in the last week of its year.
 */
$lastWeekNumber = (new DateTime('December 28th'))->format('W');

$currentWeekNumber = (new DateTime())->format('W');

$weeksLeft = $lastWeekNumber-$currentWeekNumber + 1;

$completeEachWeek = round($currentOpenTasks / $weeksLeft, 1);

$taskDifference = $resultStartWeek['total_open_tasks'] - $currentOpenTasks;

//uitrekenen: hoeveel moet ik er nog per week


//data klaar zetten voor grafiek

    //Per week

    //Van afgelopen week



include "view/page.php";