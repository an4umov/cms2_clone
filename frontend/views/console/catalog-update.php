<?php

/**
 * @var \yii\web\View $this
 * @var string $message
 */

$this->title = 'Консоль / Обновление строки каталога';
$this->params['breadcrumbs'][] = ['label' => 'Консоль', 'url' => '/console', 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => 'Обновление строки каталога', 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
?>
<div class="container mycontainer">
    <div class="row color_white">
        <div class="col-12 col-sm-12">
        <p><?= $message ?></p>
        </div>
    </div>
</div>

