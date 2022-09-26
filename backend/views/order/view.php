<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Просмотр заказа #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_ADMIN_ORDERS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_ORDERS);
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'comment:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (\common\models\Order $model) {
                    return $model->getStatusTitle($model->status).' ('.$model->status.')';
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
        ],
    ]) ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Товары</h3></div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class="panel-body" id="block-ready-form-field-list">
            <table style="width: 50%;" class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Артикул</th>
                    <th>Цена, руб</th>
                    <th>Кол-во</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($model->orderItems as $orderItem): ?>
                    <tr>
                        <td><?= $orderItem->id ?></td>
                        <td><?= $orderItem->article_number ?></td>
                        <td><?= $orderItem->price ?></td>
                        <td><?= $orderItem->quantity ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">История смены статусов заказа</h3></div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class="panel-body" id="block-ready-form-field-list">
            <table style="width: 50%;" class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Статус</th>
                    <th>Сообщение</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                <? $order = new \common\models\Order(); ?>
                <? foreach ($model->orderLogs as $orderLog): ?>
                    <tr>
                        <td><?= $orderLog->id ?></td>
                        <td><?= $order->getStatusTitle($orderLog->status) ?> (<?= $orderLog->status ?>)</td>
                        <td><?= $orderLog->message ?></td>
                        <td><?= \Yii::$app->formatter->asDatetime($orderLog->created_at) ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
