<?php

/* @var $this yii\web\View */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Test';
?>
<div class="container mycontainer">
    <div class="row" style="padding: 30px;">
        <? if (is_array($message)): ?>
            <?= '<pre>' ?>
            <? print_r($message) ?>
            <?= '</pre>' ?>
        <? elseif (is_string($message)): ?>
            <?= $message; ?>
        <? else: ?>
            <? var_dump($message); ?>
        <? endif; ?>
    </div>
</div>
<? //phpinfo(); ?>