<?php
/**
 * @var $form \common\models\Form
 * @var $fields \common\models\FormField[]
 * @var $url string
 */
?>
Форма: <?= $form->name ?>
Страница отправки формы: <?= $url ?>

Поля:
<? foreach ($fields as $field): ?>
    <?= $field->name ?>: <?= $field->value.PHP_EOL ?>
<? endforeach; ?>

Отправлено: <?= date('d.m.Y H:i:s') ?>
