<?php
/**
 * @var $type string
 * @var $brand string
 * @var $part string
 * @var $name string
 * @var $email string
 * @var $phone string
 * @var $url string
 */

$model = new \frontend\models\SendNotFoundForm();
?>
<p><strong>Отправка запроса со страницы 404:</strong> <?= $url ?></p>
<hr>
<h3>Данные</h3>
    <p><strong><?= $model->getAttributeLabel('type') ?>:</strong> <?= \yii\helpers\Html::encode($type) ?></p>
    <p><strong><?= $model->getAttributeLabel('brand') ?>:</strong> <?= \yii\helpers\Html::encode($brand) ?></p>
    <p><strong><?= $model->getAttributeLabel('part') ?>:</strong> <?= \yii\helpers\Html::encode($part) ?></p>
    <p><strong><?= $model->getAttributeLabel('name') ?>:</strong> <?= \yii\helpers\Html::encode($name) ?></p>
    <p><strong><?= $model->getAttributeLabel('email') ?>:</strong> <?= \yii\helpers\Html::encode($email) ?></p>
    <p><strong><?= $model->getAttributeLabel('phone') ?>:</strong> <?= \yii\helpers\Html::encode($phone) ?></p>
<hr>
<i>Отправлено: <?= date('d.m.Y H:i:s') ?></i>