<?php

namespace app\models\forms;

use DateTime;
use app\models\Task;
use app\models\Response;

class TaskSearchForm extends Task
{
    public array $filterCategories = [];
    public string $period = '';
    public bool $remoteJob = false;
    public bool $withoutResponse = false;

    public function filterTasks(array $queryParams): array
    {

        $query = Task::find()->where(['status' => 'STATUS_NEW']);
        if (!empty($queryParams['filterCategories'])) {
            $query->andWhere(['category_id' => $queryParams['filterCategories']]);
            $this->filterCategories = $queryParams['filterCategories'];
        }
        if (!empty($queryParams['period'])) {
            $this->period = $queryParams['period'];
            $dateTime = new DateTime('-' . $queryParams['period']);
            $query->andWhere(['>', 'created_at', $dateTime->format('Y-m-d H:i:s')]);
        }
        if (!empty($queryParams['withoutResponse'])) {
            $this->withoutResponse = true;
            $query->select(['task.*']);
            $query->joinWith('responses');
            $query->andWhere(['response.task_id' => null]);
        }
        if (!empty($queryParams['remoteJob'])) {
            $this->remoteJob = true;
            $query->andWhere(['task.city_id' => null]);
        }
        return $query->all();
    }
}
