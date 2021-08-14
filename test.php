<?php

require_once'Task.php';

$role = "executor";
$current_status = "in_progress";

$task = new Task($current_status, 1, 2, $role);
$getActions = $task->getAllActions();
$getStatuses = $task->getAllStatuses();
print("<h2>Все значения статусов</h2>");
foreach($getStatuses as $s => $value) {
    print($s." - ".$value."<br>");
}
print("<h2>Все значения действий</h2>");
foreach($getActions as $a => $value) {
    print($a." - ".$value."<br>");
}

print("<h2>Тест определения следующего статуса после конкретного действия</h2>");
$action = "take_to_work";
$getStatus = $task->getNextStatus($action);
print($getStatus);
