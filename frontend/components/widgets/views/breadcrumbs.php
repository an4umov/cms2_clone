<?php
/* @var \yii\web\View $this */
/* @var $breadcrumbs array */
?>

<!-- Breadcrumbs -->
<ul class="breadcrumbs">
    <li><a href="/"></a></li>
    <? foreach ($breadcrumbs as $breadcrumb): ?>
    <li><?= \yii\helpers\Html::a($breadcrumb['label'], $breadcrumb['url']) ?></li>
    <? endforeach; ?>
</ul>