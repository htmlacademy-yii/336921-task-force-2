<?php

/* @var $this yii\web\View */

use app\models\Category;
use app\models\City;
use app\models\UserCategory;
use app\models\User;

$this->title = 'TaskForce';

header('content-type: text/html; charset=utf-8;');

$user = User::findOne(['name' => 'Name2']);

echo '<pre>';
//print_r(Category::tableName());
//print_r(City::findOne(['name' => 'Абакан']));
//print_r(User::findOne(['name' => 'Name2']));
//print_r ($user->getCity()->all());
//print_r($user->userCategories);

// До этого комментария все работает. Связи работают. Как сделать связь между тремя классами и получить результат вида
// "Покажи название категории, к которым относится юзер Вася", я не додумалась. Максимум - могу вынуть id категории.
echo '</pre>';
exit(__FILE__ . ': ' . __LINE__);