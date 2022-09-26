<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Структура';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT);
?>
<div class="department-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить департамент', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function(\common\models\Department $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'url',
            'name',
            'catalog_code',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function (\common\models\Department $model) {
                    return (!empty($model->image) ? '<i class="'.IconHelper::ICON_IMAGES.'"></i>' : null);
                },
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;',],
            ],
            'is_active:boolean',
            [
                'attribute' => 'is_default',
                'format' => 'raw',
                'value' => function (\common\models\Department $model) {
                    return $model->is_default ? '<span class="badge bg-success">Да</span>' : 'Нет';
                },
            ],
            'sort',
            [
                'header' => 'Модели',
                'format' => 'raw',
                'value' => function (\common\models\Department $model) {
                    return '<span class="badge bg-info">'.$model->getDepartmentMenuCount().'</span> '.Html::a('<i class="fas fa-link"></i>', ['/structures/department-model', 'DepartmentModelSearch[department_id]' => $model->id,], ['title' => 'Перейти в раздел',]);
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
                'template' => "{view} &nbsp; {update}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return \yii\helpers\Html::a('<i class="fas fa-sitemap"></i>',
                            ['/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TREE, 'id' => $model->id,], [
                                'title' => 'Структура департамента',
                                'aria-label' => 'Структура департамента',
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
