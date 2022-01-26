<?php

require_once 'Task.php';

$taskStatusProgress = new Task(Task::STATUS_PROGRESS, 1, 2, Task::ROLE_EXECUTOR);

assert(!empty($taskStatusProgress->getStatusTitles()), 'Перечень статусов не возвращается');
assert(!empty($taskStatusProgress->getActionTitles()), 'Перечень экшнов не возвращается');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CANCEL) === Task::STATUS_CANCELED, 'cancel - canceled');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_CONFIRM) === Task::STATUS_DONE, 'confirm - done');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_REFUSE) === Task::STATUS_FAILED, 'refuse - failed');
assert($taskStatusProgress->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) === Task::STATUS_PROGRESS, 'take_to_work - progress');

$taskStatusNew = new Task(Task::STATUS_NEW, 1, 2, Task::ROLE_EXECUTOR);

assert($taskStatusNew->getActions(Task::ROLE_CUSTOMER) === Task::ACTION_TO_CANCEL, 'status_progress - action_to_cancel');
assert($taskStatusNew->getActions(Task::ROLE_EXECUTOR) === Task::ACTION_TO_TAKE_TO_WORK, 'status_progress - action_to_take_to_work');

