<?php

/**
 * @var \yii\web\View $this
 * @var array $result
 */

$this->title = 'Консоль / Webhooks';
?>
<div class="container mycontainer">
    <div class="row color_white">
        <div class="col-12 col-sm-12">
        <? foreach ($result as $item): ?>
        <p><?= $item ?></p>
        <? endforeach; ?>
        </div>
    </div>
</div>

