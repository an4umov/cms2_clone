<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Формы';

$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_FORMS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FORM);

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="form-index">
    <p><?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function(\common\models\Form $model){
            return ['class' => $model->getSpecialClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'name',
            'css_prefix',
            [
                'header' => 'Полей',
                'format' => 'raw',
                'value' => function (\common\models\Form $model) {
                    return '<span class="badge bg-inverse">'.$model->getFormFieldsCount().'</span>';
                },
            ],
            [
                'attribute' => 'deleted_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->deleted_at) ? '<span class="badge bg-important">Да</span>' : '<span class="badge bg-success">Нет</span>';
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at, "medium");
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' =>  function (\common\models\Form $model, $key, $index) {
                        return true;
                    },
                    'update' =>  function (\common\models\Form $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                    'delete' =>  function (\common\models\Form $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                ],
                'template' => "{view} {update} {delete}",
            ],
        ],
    ]); ?>
</div>
