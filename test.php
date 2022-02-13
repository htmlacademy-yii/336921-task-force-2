<?php

use nerodemiurgo\business\Task;
use nerodemiurgo\business\Action;

require_once "vendor/autoload.php";

$taskStatusProgress = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_EXECUTOR, 12);

assert(!empty($taskStatusProgress->getStatusTitles()), 'Перечень статусов не возвращается');
assert(!empty($taskStatusProgress->getActionTitles()), 'Перечень экшнов не возвращается');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CANCEL) === Task::STATUS_CANCELED, 'cancel - canceled');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CONFIRM) === Task::STATUS_DONE, 'confirm - done');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_REFUSE) === Task::STATUS_FAILED, 'refuse - failed');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) === Task::STATUS_PROGRESS, 'take_to_work - progress');

$taskStatusNewCust = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_CUSTOMER, 22);
assert($taskStatusNewCust->getActions(), 'Роль пользователя - заказчик, статус - новое, user_id не равен executor');
$taskStatusNewEx = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR, 13);
assert($taskStatusNewEx->getActions(), 'Роль пользователя - исполнитель, статус - новое, user_id не равен executor');
$taskStatusProgCust = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_CUSTOMER, 13);
assert($taskStatusProgCust->getActions(), 'Роль пользователя - заказчик, статус - в процессе, user_id не равен executor');
$taskStatusProgEx = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR, 13);
assert($taskStatusProgEx->getActions(), 'Роль пользователя - заказчик, статус - в процессе, user_id не равен executor');
$taskStatusFailEx = new Task(Task::STATUS_FAILED, 1, 2, Task::ROLE_EXECUTOR, 13);
assert($taskStatusProgEx->getActions(), 'Роль пользователя - исполнитель, статус - провал, user_id не равен executor');
