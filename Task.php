<?php


class Task
{

    private $customer_id;                      //ID заказчика
    private $executor_id;                      //ID исполнителя
    private $role;                             //Роль пользователя, совершившего действие
    private $actions = [];
    private $statuses = [];

    const STATUS_NEW = "new";
    const STATUS_CANCELED = "canceled";
    const STATUS_PROGRESS = "in_progress";
    const STATUS_DONE = "done";
    const STATUS_FAILED = "fail";

    const ACTION_TO_CANCEL = "cancel";
    const ACTION_TO_TAKE_TO_WORK = "take_to_work";
    const ACTION_TO_REFUSE = "refuse";
    const ACTION_TO_CONFIRM = "confirm";

    const ROLE_CUSTOMER = "customer";
    const ROLE_EXECUTOR = "executor";

    public function __construct($customer_id, $executor_id, $role)
    {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->role = $role;
    }

    /**
     * Определять список из всех доступных действий
     **/
    public function getAllActions()
    {
        $actions = [
            self::ACTION_TO_CANCEL => "Отменить",
            self::ACTION_TO_CONFIRM => "Выполнено",
            self::ACTION_TO_REFUSE => "Отказаться",
            self::ACTION_TO_TAKE_TO_WORK => "Откликнуться"
        ];
        return $actions;
    }

    /**
     * Определять список из всех доступных статусов
     **/
    public function getAllStatuses()
    {
        $statuses = [
            self::STATUS_NEW => "Новое",
            self::STATUS_DONE => "Выполнено",
            self::STATUS_CANCELED => "Отменено",
            self::STATUS_PROGRESS => "В работе",
            self::STATUS_FAILED => "Провалено"
        ];
        return $statuses;
    }

    /**
     * Определять список доступных действий в текущем статусе
     **/
    private function getActions($current_status, $role)
    {
        if ($role = self::ROLE_CUSTOMER) {
            switch ($current_status) {
                case self::STATUS_NEW:
                    return self::ACTION_TO_REFUSE;
                case self::STATUS_PROGRESS:
                    return self::ACTION_TO_CONFIRM;
            }
        }
        if ($role = self::ROLE_EXECUTOR) {
            switch ($current_status) {
                case self::STATUS_NEW:
                    return self::ACTION_TO_TAKE_TO_WORK;
                case self::STATUS_PROGRESS:
                    return self::ACTION_TO_REFUSE;
            }
        }
    }

    /**
     * Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия
     **/
    public function getNextStatus($action)
    {
        switch ($action) {
            case self::ACTION_TO_CANCEL:
                return self::STATUS_CANCELED;
            case self::ACTION_TO_CONFIRM:
                return self::STATUS_DONE;
            case self::ACTION_TO_REFUSE:
                return self::STATUS_FAILED;
            case self::ACTION_TO_TAKE_TO_WORK:
                return self::STATUS_PROGRESS;
            default:
                return self::STATUS_NEW;
        }
    }
}
