<?php

use backend\components\helpers\IconHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReferenceBuyerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->getClassTitle();
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/references',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon(\common\components\helpers\ReferenceHelper::getClassIcon());

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="content-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function(\common\models\References $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'columns' => [
            'id',
            'name',
            'is_active:boolean',
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
                    'update' =>  function (\common\models\References $model, $key, $index) {
                        return true;
                    },
                    'delete' =>  function (\common\models\References $model, $key, $index) {
                        return !empty($model->is_active);
                    },
                ],
                'template' => "{update} {delete}",
            ],
        ],
    ]); ?>
</div>

