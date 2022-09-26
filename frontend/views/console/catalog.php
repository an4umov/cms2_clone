<?php

/**
 * @var \yii\web\View $this
 * @var array $messages
 */

$this->title = 'Консоль / Миграция каталога';
$this->params['breadcrumbs'][] = ['label' => 'Консоль', 'url' => '/console', 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => 'Миграция каталога', 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
?>
<div class="container mycontainer">
    <div class="row color_white">
        <div class="col-12 col-sm-12">
        <? foreach ($messages as $message): ?>
        <p><?= $message ?></p>
        <? endforeach; ?>
        </div>
    </div>
</div>

