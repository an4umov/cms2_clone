<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DepartmentMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню департаментов';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MENU;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MENU);
?>
<div class="department-menu-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function(\common\models\DepartmentMenu $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            [
                'attribute' => 'department_id',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentMenu $model) {
                    return $model->department ? $model->department->name : null;
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
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentMenu $model) {
                    return ($model->department ? Html::tag('strong', $model->department->url.'/ ', ['class' => 'text-danger',]) : '').$model->url;
                },
            ],
            'name',
            [
                'attribute' => 'landing_page_type',
                'format' => 'html',
                'value' => function (\common\models\DepartmentMenu $model) {
                    return $model->getStatusTitle($model->landing_page_type);
                },
            ],
            [
                'attribute' => 'icon',
                'format' => 'html',
                'value' => function (\common\models\DepartmentMenu $model) {
                    return !empty($model->icon) ? '<i class="'.$model->icon.'"></i>' : null;
                },
            ],
            'is_active:boolean',
            [
                'header' => 'Тематик',
                'format' => 'raw',
                'value' => function (\common\models\DepartmentMenu $model) {
                    return '<span class="badge bg-success">'.$model->getTagCount().'</span>';
                },
            ],
            'sort',
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
