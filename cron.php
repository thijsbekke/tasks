<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 22:28
 */

if(php_sapi_name() !== 'cli') {
    exit();
}
require_once "weare.php";


$store = new TokenCache();
$token = $store->getAccessToken();

if (empty($token)) {
    //loggen ?
    die();
}

//Checken of er al 1 bestaat nu ?
$result = Database::getInstance()->fetchRow('
  SELECT * 
  FROM statistics 
  WHERE 1
    AND DATE_FORMAT(datetime, "%Y-%m-%d") = DATE_FORMAT(NOW(), "%Y-%m-%d")
  ORDER BY datetime DESC
  LIMIT 1
');

$task = new Task();
$totalOpenTasks = $task->count();

//Checken hoeveel er zijn opgelost ?


if($result != null && $totalOpenTasks == $result['total_open_tasks']) {
    //record bestaat al, skippen aangezien dit geen nut heeft.
    die();
}
$data = [
    'datetime'   => (new DateTime())->format('Y-m-d H:i:s'),
    'total_open_tasks' => $totalOpenTasks,
];

Database::getInstance()->insert('statistics', $data);


