<?php


namespace nerodemiurgo\business;


class ConfirmAction implements Action
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
        if ($user_id === $customer_id & $current_status === "in_progress") {
            return true;
        } else return false;
    }
}
