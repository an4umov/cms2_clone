<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CustomTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TAG;

$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_TAGS);
?>
<div class="department-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function(\common\models\CustomTag $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'name',
            'is_active:boolean',
            [
                'header' => 'Используется',
                'format' => 'raw',
                'value' => function (\common\models\CustomTag $model) {
                    return '<span class="badge bg-success">'.$model->getContentCustomTagsCount().'</span>';
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
