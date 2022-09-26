<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\News $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => '/news', 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
?>

<h1><?= $this->title ?></h1>

<div class="blockk1">
    <div class="container mycontainer">
        <div class="row">
            <div class="col">
                <section>
                <pre><? print_r($model->getDecodedDescription()) ?></pre>
                </section>
            </div>
        </div>
    </div>
</div>