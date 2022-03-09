<?php
declare(strict_types=1);

namespace nerodemiurgo\business;

use nerodemiurgo\ex\CheckDataException;

class Task
{
    private string $current_status;                   //Текущий статус, обязательное
    private int $customer_id;                         //ID заказчика
    private int $executor_id;                         //ID исполнителя
    private string $role;                             //Роль пользователя, совершившего действие

    public const STATUS_NEW = "new";                  //Статус новое
    public const STATUS_CANCELED = "canceled";        //Статус отменено
    public const STATUS_PROGRESS = "in_progress";     //Статус в работе
    public const STATUS_DONE = "done";                //Статус выполнено
    public const STATUS_FAILED = "fail";              //Статус провалено
    public const STATUSES = [
        self::STATUS_NEW => "Новое",
        self::STATUS_DONE => "Выполнено",
        self::STATUS_CANCELED => "Отменено",
        self::STATUS_PROGRESS => "В работе",
        self::STATUS_FAILED => "Провалено"
    ];

    public const ACTION_TO_CANCEL = "cancel";             //Отменить
    public const ACTION_TO_TAKE_TO_WORK = "take_to_work"; //Откликнуться
    public const ACTION_TO_REFUSE = "refuse";             //Отказаться
    public const ACTION_TO_CONFIRM = "confirm";           //Выполнено (подтвердить выполнение)
    public const ACTIONS = [
        self::ACTION_TO_CANCEL => "Отменить",
        self::ACTION_TO_CONFIRM => "Выполнено",
        self::ACTION_TO_REFUSE => "Отказаться",
        self::ACTION_TO_TAKE_TO_WORK => "Откликнуться"
    ];

    public const ROLE_CUSTOMER = "customer";
    public const ROLE_EXECUTOR = "executor";

    /**
     * @throws CheckDataException
     */
    public function __construct(string $current_status, int $customer_id, int $executor_id, string $role)
    {
        if (!array_key_exists($current_status, self::STATUSES)) {
            throw new CheckDataException("Полученный статус не существует");
        }

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
     *
     * @throws CheckDataException
     */

    public function getAction($user_id): ?Action
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
        elseif ($this->role === self::ROLE_EXECUTOR) {
            $action = new RefuseAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
            $action = new TakeToWorkAction();
            if ($action->checkAccess($this->customer_id, $this->executor_id, $user_id, $this->current_status)) {
                return $action;
            }
        } else {
            throw new CheckDataException("Роль пользователя не определена");
        }
        return null;
    }

    /**
     * Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия
     *
     * @throws CheckDataException
     */
    public function getNextStatus(string $action): string
    {
        if (!array_key_exists($action, self::ACTIONS)) {
            throw new CheckDataException("Полученное действие не существует");
        }
        return match ($action) {
            self::ACTION_TO_CANCEL => self::STATUS_CANCELED,
            self::ACTION_TO_CONFIRM => self::STATUS_DONE,
            self::ACTION_TO_REFUSE => self::STATUS_FAILED,
            self::ACTION_TO_TAKE_TO_WORK => self::STATUS_PROGRESS,
            default => self::STATUS_NEW,
        };
    }
}
