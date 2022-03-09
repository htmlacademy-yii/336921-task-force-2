<?php

use nerodemiurgo\business\Task;
use nerodemiurgo\business\CancelAction;
use nerodemiurgo\business\ConfirmAction;
use nerodemiurgo\business\RefuseAction;
use nerodemiurgo\business\TakeToWorkAction;
use nerodemiurgo\ex\CheckDataException;

require_once "vendor/autoload.php";

$taskStatusProgress = new Task(Task::STATUS_PROGRESS, 1, 2,"kkk");

assert(!empty($taskStatusProgress->getStatusTitles()), 'Перечень статусов не возвращается');
assert(!empty($taskStatusProgress->getActionTitles()), 'Перечень экшнов не возвращается');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CANCEL) === Task::STATUS_CANCELED, 'cancel - canceled');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CONFIRM) === Task::STATUS_DONE, 'confirm - done');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_REFUSE) === Task::STATUS_FAILED, 'refuse - failed');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) === Task::STATUS_PROGRESS, 'take_to_work - progress');

$taskStatusNewCust = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_CUSTOMER);
assert(!empty($taskStatusNewCust->getAction(1)), 'Залогиненный пользователь не создатель задания');
assert(($taskStatusNewCust->getAction(1) instanceof CancelAction), 'Неверный пользователь или объект другого класса');

$taskStatusNewEx = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR);
assert(!empty($taskStatusNewEx->getAction(2)), 'Залогиненный пользователь не исполнитель задания');
assert(($taskStatusNewEx->getAction(2) instanceof TakeToWorkAction), 'Неверный пользователь или объект другого класса');

$taskStatusProgCust = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_CUSTOMER);
assert(!empty($taskStatusProgCust->getAction(1)), 'Залогиненный пользователь не создатель задания');
assert(($taskStatusProgCust->getAction(1) instanceof ConfirmAction), 'Неверный пользователь или объект другого класса');

$taskStatusProgEx = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_EXECUTOR);
assert(!empty($taskStatusProgEx->getAction(2)), 'Залогиненный пользователь не исполнитель задания');
assert(($taskStatusProgEx->getAction(2) instanceof RefuseAction), 'Неверный пользователь или объект другого класса');

$taskStatusFailEx = new Task(Task::STATUS_FAILED, 1, 2, Task::ROLE_EXECUTOR);
assert(empty($taskStatusFailEx->getAction(1)), 'Статус не подразумевает действий');

try {
    $taskStatusProgress->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) === Task::STATUS_PROGRESS;
} catch (CheckDataException $e) {
    print("Ошибка: ".$e);
}

try {
    $taskStatusProgress->getAction(6);
} catch (CheckDataException $e) {
    print("Ошибка: " .$e);
}
