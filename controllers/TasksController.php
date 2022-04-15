<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Task;

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
        $tasks = $this->getTasks();
        return $this->render('index', compact("tasks"));
    }

}