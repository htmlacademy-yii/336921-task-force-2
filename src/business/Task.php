<?php
declare(strict_types=1);

namespace nerodemiurgo\business;

use nerodemiurgo\business\Action;

class Task
{
    private string $current_status;                   //Текущий статус, обязательное
    private int $customer_id;                         //ID заказчика
    private int $executor_id;                         //ID исполнителя
    private string $role;                             //Роль пользователя, совершившего действие
    private int $user_id;                             //Идентификатор текущего пользователя

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
    public function getActionTitles(): array
    {
        return self::ACTIONS;
    }

    /**
     * Определять список из всех доступных статусов
     **/
    public function getStatusTitles(): array
    {
        return self::STATUSES;
    }

    /**
     * Определять список доступных действий в текущем статусе
     * @return ?Action
     **/

    public function getAction($user_id): ?object
    {
        if ($this->role === self::ROLE_CUSTOMER) {
            $action = new CancelAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
            $action = new ConfirmAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
        }
        if ($this->role === self::ROLE_EXECUTOR) {
            $action = new RefuseAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
            $action = new TakeToWorkAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
        }
        return null;
    }

    /**
     * Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия
     **/
    public function getNextStatus(string $action): string
    {
        return match ($action) {
            self::ACTION_TO_CANCEL => self::STATUS_CANCELED,
            self::ACTION_TO_CONFIRM => self::STATUS_DONE,
            self::ACTION_TO_REFUSE => self::STATUS_FAILED,
            self::ACTION_TO_TAKE_TO_WORK => self::STATUS_PROGRESS,
            default => self::STATUS_NEW,
        };
    }
}
