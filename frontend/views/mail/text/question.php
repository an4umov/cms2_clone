<?php
/**
 * @var $id integer
 * @var $type string
 * @var $name string
 * @var $email string
 * @var $comment string
 * @var $url string
 */

$model = new \common\models\QuestionSended();
?>
Страница отправки вопроса со страницы: <?= $url ?>

Данные:
<?= $model->getAttributeLabel('name') ?>: <?= \yii\helpers\Html::encode($name) ?>
<?= $model->getAttributeLabel('email') ?>: <?= $email ?>
<?= $model->getAttributeLabel('comment') ?>: <?= \yii\helpers\Html::encode($comment) ?>

Отправлено: <?= date('d.m.Y H:i:s') ?>
