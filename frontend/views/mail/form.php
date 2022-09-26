<?php
/**
 * @var $form \common\models\Form
 * @var $fields \common\models\FormField[]
 * @var $url string
 */
?>
<h1><?= $form->name ?></h1>
<p>
    <strong>Страница отправки формы:</strong> <?= $url ?>
</p>
<hr>
<h3>Поля</h3>
<? foreach ($fields as $field): ?>
    <p><strong><?= $field->name ?>:</strong> <?= $field->value ?></p>
<? endforeach; ?>
<hr>
<i>Отправлено: <?= date('d.m.Y H:i:s') ?></i>