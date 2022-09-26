<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $ids array */

$this->title = $searchModel->getManyTypeTitle($searchModel->type);
$this->params['breadcrumbs'][] = ['label' => 'Контент', 'url' => ['/'.MenuHelper::FIRST_MENU_CONTENT,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menuIcon'] = IconHelper::getSpanIcon($searchModel->getTypeIcon($searchModel->type));

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="content-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function(\common\models\Content $model){
            return ['class' => $model->getPageClass(),];
        },
        'columns' => [
            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (\common\models\Content $model) use ($ids) {
                    return $model->name.(isset($ids[$model->id]) ? ' '.Html::tag('span', '', ['class' => \backend\components\helpers\IconHelper::ICON_STRUCTURES, 'title' => 'Установлена как посадочная страница',]) : '');
                },
            ],
            'alias',
            [
                'attribute' => 'alias',
                'header' => 'Урл для сайта',
                'format' => 'raw',
                'value' => function (\common\models\Content $model) {
                    return Html::tag('span', '/'.$model->getTypeToTypesTitle($model->type).'/', ['class' => 'text-primary',]).($model->alias ?: $model->id);
                },
            ],
            [
                'header' => 'Главная',
                'format' => 'raw',
                'value' => function (\common\models\Content $model) {
                    return $model->is_index_page ? '<span class="badge bg-success">Да</span>' : null;
                },
                'visible' => false, //$searchModel->type === \common\models\Content::TYPE_PAGE || $searchModel->type === \common\models\Content::TYPE_NEWS,
            ],
            [
                'attribute' => 'views',
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;width:1%;',],
            ],
            [
                'header' => 'Блоков',
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;width:1%;',],

                'value' => function (\common\models\Content $model) {
                    return '<span class="badge bg-inverse">'.$model->getAllBlocksCount().'</span>';
                },
            ],
            [
                'attribute' => 'deleted_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->deleted_at) ? '<span class="badge bg-important">Да</span>' : '<span class="badge bg-success">Нет</span>';
                },
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;width:1%;',],
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
                'visibleButtons' => [
                    'update' =>  function (\common\models\Content $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                    'delete' =>  function (\common\models\Content $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                ],
                'template' => "{update} {delete}",
            ],
        ],
    ]); ?>
</div>

