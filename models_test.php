<?php

use app\models\Category;
use app\models\City;
use app\models\Response;
use app\models\Review;
use app\models\Task;
use app\models\User;
use yii\db\ActiveRecord;
use yii\web\Controller;


require_once "vendor/autoload.php";
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

assert(!empty(Category::tableName()), 'Не пришло название таблицы категорий');
print_r(Category::tableName());
assert(!empty(City::tableName()), 'Не пришло название таблицы города');
var_dump(City::find()->one());
print_r(City::findOne(['name' => 'Абакан']));
