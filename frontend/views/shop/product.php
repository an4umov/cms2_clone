<?php

/**
 * @var \yii\web\View $this
 * @var string $code
 * @var string $key
 */

use \yii\helpers\Html;
use \common\components\helpers\CatalogHelper;

$this->title = 'Product key #'.$key;

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog',], 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,];
//$this->params['breadcrumbs'][] = ['label' => $catalog->name, 'url' => ['/shop/code', 'code' => $catalog->code,], 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,];
?>

<h1 class="product_title">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?= $code ?>
            </div>
        </div>
    </div>
</h1>

<h3 class="product_title">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?= $key ?>
            </div>
        </div>
    </div>
</h3>
