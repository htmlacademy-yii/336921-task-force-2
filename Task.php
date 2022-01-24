<?php


class Task
{
    private $current_status;                   //Текущий статус, обязательное
    private $customer_id;                      //ID заказчика
    private $executor_id;                      //ID исполнителя
    private $role;                             //Роль пользователя, совершившего действие

    const STATUS_NEW = "new";                  //Статус новое
    const STATUS_CANCELED = "canceled";        //Статус отменено
    const STATUS_PROGRESS = "in_progress";     //Статус в работе
    const STATUS_DONE = "done";                //Статус выполнено
    const STATUS_FAILED = "fail";              //Статус провалено
    const STATUSES = [
        self::STATUS_NEW => "Новое",
        self::STATUS_DONE => "Выполнено",
        self::STATUS_CANCELED => "Отменено",
        self::STATUS_PROGRESS => "В работе",
        self::STATUS_FAILED => "Провалено"
    ];

    const ACTION_TO_CANCEL = "cancel";             //Отменить
    const ACTION_TO_TAKE_TO_WORK = "take_to_work"; //Откликнуться
    const ACTION_TO_REFUSE = "refuse";             //Отказаться
    const ACTION_TO_CONFIRM = "confirm";           //Выполнено (подтвердить выполнение)
    const ACTIONS = [
        self::ACTION_TO_CANCEL => "Отменить",
        self::ACTION_TO_CONFIRM => "Выполнено",
        self::ACTION_TO_REFUSE => "Отказаться",
        self::ACTION_TO_TAKE_TO_WORK => "Откликнуться"
    ];

    const ROLE_CUSTOMER = "customer";
    const ROLE_EXECUTOR = "executor";

    public function __construct(string $current_status, int $customer_id, int $executor_id, string $role)
    {
        $this->current_status = $current_status;
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->role = $role;
    }

    /**
     * Определять список из всех доступных действий
     **/
    public function getAllActions(): array
    {
        return self::ACTIONS;
    }

    /**
     * Определять список из всех доступных статусов
     **/
    public function getAllStatuses(): array
    {
        return self::STATUSES;
    }

    /**
     * Определять список доступных действий в текущем статусе
     **/
    private function getActions(string $current_status, string $role): string
    {
        if ($this->role == self::ROLE_CUSTOMER) {
            switch ($current_status) {
                case self::STATUS_NEW:
                    return self::ACTION_TO_CANCEL;
                case self::STATUS_PROGRESS:
                    return self::ACTION_TO_CONFIRM;
            }
        }
        if ($this->role == self::ROLE_EXECUTOR) {
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
    public function getNextStatus(string $action): string
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
