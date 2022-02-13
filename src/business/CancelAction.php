<?php


namespace nerodemiurgo\business;


class CancelAction implements Action
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
        if ($user_id === $customer_id & $current_status === "new") {
            return true;
        } else return false;
    }
}
