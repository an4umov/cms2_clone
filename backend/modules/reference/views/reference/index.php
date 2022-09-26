<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReferenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочники';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_REFERENCES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_REFERENCES_REFERENCE;
$this->params['menuIcon'] = IconHelper::getSpanIcon(\common\components\helpers\ReferenceHelper::getClassIcon());
?>
<div class="reference-index">
    <p><?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function(\common\models\Reference $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'name',
            'is_active:boolean',
            [
                'header' => 'Значений',
                'format' => 'raw',
                'value' => function (\common\models\Reference $model) {
                    return $model->getReferenceValuesCount();
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
