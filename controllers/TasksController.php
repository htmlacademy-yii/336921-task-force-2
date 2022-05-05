<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Task;
use app\models\Category;
use app\models\forms\TaskSearchForm;
use nerodemiurgo\services\TaskService;
use yii\helpers\ArrayHelper;

class TasksController extends Controller
{
    public function getTasks()
    {
        return Task::find()
            ->where(['status' => 'STATUS_NEW'])
            ->joinWith(['category', 'city'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    public function actionIndex()
    {
        $taskSearchForm = new TaskSearchForm();

        $request = Yii::$app->request;
        if ($request->isGet && !empty($request->queryParams['TaskSearchForm'])) {
            $newTasks = $taskSearchForm->filterTasks($request->queryParams['TaskSearchForm']);
        } else {
            $newTasks = $this->getTasks();
        }
        $categories = Category::find()->indexBy('id')->all();
        $taskService = new TaskService($newTasks, $categories);
        $listTasks = $taskService->getListTasks();
        $listPeriods = $taskService->getListPeriods();

        return $this->render(
            'index',
            [
                'tasks' => $listTasks,
                'categories' => $categories,
                'taskSearchForm' => $taskSearchForm,
                'listPeriods' => $listPeriods,
            ]
        );
    }
}
