<?php


namespace nerodemiurgo\business;


class TakeToWorkAction extends Action
{

    public function getTitle(): string
    {
        return 'Откликнуться';
    }

    public function getCode(): string
    {
        return 'take_to_work';
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $executor_id && $current_status === Task::STATUS_NEW);
    }
}
