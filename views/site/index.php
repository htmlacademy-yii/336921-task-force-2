<?php

/* @var $this yii\web\View */

use app\models\Category;
use app\models\City;


$this->title = 'TaskForce';

assert(!empty(Category::tableName()), 'Не пришло название таблицы категорий');
print_r(Category::tableName());
assert(!empty(City::tableName()), 'Не пришло название таблицы города');
var_dump(City::find()->one());
print_r(City::findOne(['name' => 'Абакан']));