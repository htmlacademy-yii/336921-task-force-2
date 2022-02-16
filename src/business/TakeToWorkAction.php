<?php


namespace nerodemiurgo\business;


class TakeToWorkAction extends Action
{

    public function __construct()
    {
        $this->title = 'Откликнуться';
        $this->code = 'take_to_work';
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
        if ($user_id === $executor_id && $current_status === Task::STATUS_NEW) {
            return true;
        } else return false;
    }
}
