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
<p>
    <strong>Страница отправки вопроса со страницы:</strong> <?= $url ?>
</p>
<hr>
<h3>Данные</h3>
    <p><strong><?= $model->getAttributeLabel('name') ?>:</strong> <?= \yii\helpers\Html::encode($name) ?></p>
    <p><strong><?= $model->getAttributeLabel('email') ?>:</strong> <?= $email ?></p>
    <p><strong><?= $model->getAttributeLabel('comment') ?>:</strong> <?= \yii\helpers\Html::encode($comment) ?></p>
<hr>
<i>Отправлено: <?= date('d.m.Y H:i:s') ?></i>