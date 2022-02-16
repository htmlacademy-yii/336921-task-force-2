<?php

use nerodemiurgo\business\Task;

require_once "vendor/autoload.php";

$taskStatusProgress = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_EXECUTOR);

assert(!empty($taskStatusProgress->getStatusTitles()), 'Перечень статусов не возвращается');
assert(!empty($taskStatusProgress->getActionTitles()), 'Перечень экшнов не возвращается');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CANCEL) === Task::STATUS_CANCELED, 'cancel - canceled');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CONFIRM) === Task::STATUS_DONE, 'confirm - done');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_REFUSE) === Task::STATUS_FAILED, 'refuse - failed');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) === Task::STATUS_PROGRESS, 'take_to_work - progress');

$taskStatusNewCust = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_CUSTOMER);
assert(!empty($taskStatusNewCust->getActions(1)), 'Залогиненный пользователь не создатель задания');
$taskStatusNewEx = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR);
assert(!empty($taskStatusNewEx->getActions(2)), 'Залогиненный пользователь не исполнитель задания');
$taskStatusProgCust = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_CUSTOMER);
assert(!empty($taskStatusProgCust->getActions(1)), 'Залогиненный пользователь не создатель задания');
$taskStatusProgEx = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR);
assert(!empty($taskStatusProgEx->getActions(2)), 'Залогиненный пользователь не исполнитель задания');
$taskStatusFailEx = new Task(Task::STATUS_FAILED, 1, 2, Task::ROLE_EXECUTOR);
assert(empty($taskStatusFailEx->getActions(1)), 'Статус не подразумевает действий');
