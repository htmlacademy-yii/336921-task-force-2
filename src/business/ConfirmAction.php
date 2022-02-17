<?php


namespace nerodemiurgo\business;


class ConfirmAction extends Action
{
    public function __construct()
    {
        $this->title = 'Выполнено';
        $this->code = 'confirm';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool
    {
        return ($user_id === $customer_id && $current_status === Task::STATUS_PROGRESS);
    }
}
