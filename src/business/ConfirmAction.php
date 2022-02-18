<?php


namespace nerodemiurgo\business;


class ConfirmAction extends Action
{

    public function getTitle(): string
    {
        return 'Выполнено';
    }

    public function getCode(): string
    {
        return 'confirm';
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $customer_id && $current_status === Task::STATUS_PROGRESS);
    }
}
