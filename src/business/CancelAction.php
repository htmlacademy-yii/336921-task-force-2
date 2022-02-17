<?php


namespace nerodemiurgo\business;


class CancelAction extends Action
{
    public function __construct()
    {
        $this->title = 'Отменить';
        $this->code = 'cancel';
    }

    public function getTitle(): string
    {
        return 'Отменить';
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $customer_id && $current_status === Task::STATUS_NEW);
    }
}
