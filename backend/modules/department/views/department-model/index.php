<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DepartmentModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели департаментов';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MODEL;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MODEL);
?>
<div class="department-model-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            [
                'attribute' => 'department_id',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentModel $model) {
                    return Html::a($model->department->name, ['/department/department/update', 'id' => $model->department_id,]);
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'department_id',
                    'data' => \common\models\DepartmentMenu::getDepartmentOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать департамент...',
                        'multiple' => false,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            'word_1',
            'word_2',
            [
                'header' => 'Записей',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentModel $model) {
                    return '<span class="badge bg-primary">'.$model->getListCount().'</span>';
                },
            ],
            [
                'header' => 'Меню',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentModel $model) {
                    return '<span class="badge bg-success">'.$model->getDepartmentMenuCount().'</span> '.Html::a('<i class="fas fa-link"></i>', ['/structures/department-menu', 'DepartmentMenuSearch[department_model_id]' => $model->id,], ['title' => 'Перейти в раздел',]);
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}",
            ],
        ],
    ]); ?>
</div>
