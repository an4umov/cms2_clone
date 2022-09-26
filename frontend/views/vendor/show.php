<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Articles $model
 */

$this->title = 'Статья';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use yii\helpers\Url;
?>

<h1><?= $this->title ?></h1>

<div class="container mycontainer">
    <div class="row">
        <div class="col">
            <section id="readmore" class="readmore-js-section readmore-js-collapsed">
                <p><?= $model->description ?></p>
        </div>
    </div>
</div>