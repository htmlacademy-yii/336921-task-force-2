<?php


namespace nerodemiurgo\business;


class CancelAction extends Action
{

    public function getTitle(): string
    {
        return 'Отменить';
    }

    public function getCode(): string
    {
        return 'cancel';
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $customer_id && $current_status === Task::STATUS_NEW);
    }
}
