<?php


namespace nerodemiurgo\business;


abstract class Action
{
    abstract public function getTitle(): string;

    abstract public function getCode(): string;

    abstract public function checkAccess(int $customer_id, int $executor_id, int $user_id, string $current_status): bool;

}
