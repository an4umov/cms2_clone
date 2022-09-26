<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Order $model
 */

$this->title = 'Заказ '.$model->id.' оплачен';
?>
<div class="container mycontainer">
    <h1><?= $this->title ?></h1>
    <h4>Статус заказа: <?= $model->status ?></h4>
    <h4>комментарий: <?= $model->comment ?></h4>
    <table style="width: 50%;">
        <caption>Товары</caption>
        <thead>
        <tr>
            <th>#</th>
            <th>Артикул</th>
            <th>Цена</th>
            <th>Кол-во</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($model->orderItems as $orderItem): ?>
        <tr>
            <td style="text-align: center;"><?= $orderItem->id ?></td>
            <td style="text-align: center;"><?= $orderItem->article_number ?></td>
            <td style="text-align: center;"><?= $orderItem->price ?></td>
            <td style="text-align: center;"><?= $orderItem->quantity ?></td>
        </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</div>
