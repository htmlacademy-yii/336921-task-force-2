<?php


namespace nerodemiurgo\business;


class RefuseAction extends Action
{

    public function getTitle(): string
    {
        return 'Отказаться';
    }

    public function getCode(): string
    {
        return 'refuse';
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $executor_id && $current_status === Task::STATUS_PROGRESS);
    }
}
