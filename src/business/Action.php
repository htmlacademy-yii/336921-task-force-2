<?php


namespace nerodemiurgo\business;


interface Action
{
    public function getTitle(): string;

    public function getCode(): string;

    public function checkAccess($customer_id, $executor_id, $user_id, $current_status): bool;

}
