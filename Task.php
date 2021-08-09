<?php


class Task
{
    public $current_status = "";                  //Текущий статус, обязательное
    public $action = "";                          //Пришедшее действие
    public $customer_id = 0;                      //ID заказчика, обязательное
    public $executor_id = 0;                      //ID исполнителя, обязательноe
    public $role = "";                            //Роль пользователя, совершившего действий

    const STATUSES = [
        'new',                    //Статус новое
        'canceled',               //Статус отменено
        'in_progress',            //Статус в работе
        'done',                   //Статус выполнено
        'failed'                  //Статус провалено
    ];

    const ACTIONS = [
       'to_cancel'       => ['cancel'],             //Отменить заказ
       'to_take_to_work' => ['take_to_work'],       //Откликнуться на заказ
       'to_refuse'       => ['refuse'],             //Отказаться от выполнения заказа
       'to_confirm'      => ['confirm']             //Подтвердить выполнение заказа
    ];

    public function __construct($customer_id, $executor_id, $current_status, $role) {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->current_status = $current_status;
        $this->role = $role;
    }

// Определять список из всех доступных действий
    public function getAllActions() {
        $actions = array_keys(self::ACTIONS);
        return $actions;
    }
// Определять список из всех доступных статусов
    public function getAllStatuses() {
        $statuses = array_keys(self::STATUSES);
        return $statuses;
    }
// Определять список доступных действий в текущем статусе
    private function getActions($current_status, $role) {
        if ($role = "customer") {
            switch ($current_status) {
                case self::STATUSES['new']:
                    return self::ACTIONS['to_refuse'];
                case self::STATUSES['in_progress']:
                    return self::ACTIONS['to_confirm'];
            }
        }
        if ($role = "executor") {
            switch ($current_status) {
                case self::STATUSES['new']:
                    return self::ACTIONS['to_take_to_work'];
                case self::STATUSES['in_progress']:
                    return self::ACTIONS['to_refuse'];
            }
        }
    }
// Возвращать имя статуса, в который перейдёт задание после выполнения конкретного действия;
    public function getNextStatus($action) {
        switch ($action) {
            case self::ACTIONS['to_cancel']:
                return self::STATUSES['canceled'];
            case self::ACTIONS['to_confirm']:
                return self::STATUSES['done'];
            case self::ACTIONS['to_refuse']:
                return self::STATUSES['fail'];
            case self::ACTIONS['to_take_to_work']:
                return self::STATUSES['in_progress'];
            default:
                return self::STATUSES['new'];
        }
    }
}
