<?php


namespace nerodemiurgo\business;


class RefuseAction implements Action
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
        if ($user_id === $executor_id & $current_status === "in_progress") {
            return true;
        } else return false;
    }
}
