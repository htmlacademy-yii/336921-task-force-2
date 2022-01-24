<?php

require_once 'Task.php';

$role = Task::ROLE_EXECUTOR;
$current_status = Task::STATUS_PROGRESS;

$task = new Task($current_status, 1, 2, $role);

assert($task->getAllStatuses(), 'Перечень статусов не возвращается');
assert($task->getAllActions(), 'Перечень экшнов не возвращается');
assert($task->getNextStatus(Task::ACTION_TO_CANCEL) == Task::STATUS_CANCELED, 'cancel - canceled');
assert($task->getNextStatus(Task::ACTION_TO_CONFIRM) == Task::STATUS_DONE, 'confirm - done');
assert($task->getNextStatus(Task::ACTION_TO_REFUSE) == Task::STATUS_FAILED, 'refuse - failed');
assert($task->getNextStatus(Task::ACTION_TO_TAKE_TO_WORK) == Task::STATUS_PROGRESS, 'take_to_work - progress');
