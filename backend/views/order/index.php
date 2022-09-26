<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_ADMIN_ORDERS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_ORDERS);
?>
<div class="order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user_id',
            [
                'header' => 'Товары',
                'format' => 'raw',
                'value' => function (\common\models\Order $model) {
                    return $model->getOrderItemsCount();
                },
            ],
            [
                'header' => 'Стоимость, руб',
                'format' => 'raw',
                'value' => function (\common\models\Order $model) {
                    return $model->getOrderItemsCost();
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (\common\models\Order $model) {
                    return $model->getStatusTitle($model->status);
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => $searchModel->getStatusTitles(),
                    'options' => [
                        'placeholder' => 'Выбрать ...',
                        'multiple' => false,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
            ],
        ],
    ]); ?>
</div>
