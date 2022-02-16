<?php


namespace nerodemiurgo\business;


class RefuseAction extends Action
{

    public function __construct()
    {
        $this->title = 'Отказаться';
        $this->code = 'refuse';
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
        if ($user_id === $executor_id && $current_status === Task::STATUS_PROGRESS) {
            return true;
        } else return false;
    }
}
