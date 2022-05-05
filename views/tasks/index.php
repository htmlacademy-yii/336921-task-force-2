<?php
$this->title = 'Новые задания';

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="left-column">
<h3><?= Html::encode($this->title)?></h3>
    <?php foreach ($tasks as $task) : ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?= Html::encode($task['name'])?></a>
                <p class="price price--task"><?= Html::encode($task['budget'])?></p>
            </div>
            <p class="info-text"><span class="current-time"><?= Html::encode($task['relative_time'])?></span> назад</p>
            <p class="task-text"><?= Html::encode($task['description'])?></p>
            <div class="footer-task">
                <p class="info-text town-text"><?= Html::encode($task['city_name'] )?></p>
                <p class="info-text category-text"><?= Html::encode($task['category_name'])?></p>
                <a href="<?=Url::to('task/' . $task['task_id'], true)?>" class="button button--black">
                    Смотреть Задание
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="pagination-wrapper">
        <ul class="pagination-list">
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">1</a>
            </li>
            <li class="pagination-item pagination-item--active">
                <a href="#" class="link link--page">2</a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">3</a>
            </li>
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
        </ul>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
    <div class="search-form">
            <?php $form = ActiveForm::begin([
                'id' => 'searched-new-tasks',
                'method' => 'get',
                'options' => [
                    'name' => 'test',
                ],
                'action' => [
                    '/tasks',
                ],
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]); ?>
            <h4 class="head-card">Категории</h4>
            <div class="form-group">
                <div>
                    <?php foreach ($categories as $category) : ?>
                    <div class="category">
                        <?= $form->field($taskSearchForm, 'filterCategories[]', [
                            'template' => '{input}',
                        ])->checkbox([
                            'label' => false,
                            'value' => Html::encode($category->id),
                            'uncheck' => null,
                            'checked' => in_array($category->id, $taskSearchForm->filterCategories),
                            'id' => Html::encode($category->id),
                        ]) ?>
                        <label class="control-label" for="<?=Html::encode($category->id)?>">
                            <?=Html::encode($category->name)?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                
            </div>
            <h4 class="head-card">Дополнительно</h4>
            <div class="form-group">
                <div class="extra">
                    <?= $form->field($taskSearchForm, 'withoutResponse', [
                        'template' => '{input}',
                    ])->checkbox([
                        'label' => false,
                        'value' => Html::encode('withoutResponse'),
                        'uncheck' => null,
                        'checked' => $taskSearchForm->withoutResponse,
                        'id' => 'without-response',
                    ]) ?>
                    <label class="control-label" for="without-response">Без откликов</label>
                </div>
                <div class="extra">
                    <?= $form->field($taskSearchForm, 'remoteJob', [
                        'template' => '{input}',
                    ])->checkbox([
                        'label' => false,
                        'value' => Html::encode('remoteJob'),
                        'uncheck' => null,
                        'checked' => $taskSearchForm->remoteJob,
                        'id' => 'remote-job',
                    ]) ?>
                    <label class="control-label" for="remote-job">Удаленная работа</label>
                </div>
            </div>
            <h4 class="head-card">Период</h4>
            <div class="form-group">
                <label for="period-value"></label>
                <?= $form->field($taskSearchForm, 'period', [
                    'template' => '{input}',
                ])->dropDownList(
                    $listPeriods,
                    [
                        'id' => 'period-value',
                        'class' => null,
                    ]
                ) ?>
            </div>
            <?= Html::submitButton('Искать', ['class' => 'button button--blue']) ?>
            <?php $form = ActiveForm::end(); ?>
        </div>
    </div>
</div>