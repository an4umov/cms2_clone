<?php

/* @var $this yii\web\View */
/* @var array $models */
/* @var string $header */
/* @var string $headerColor */

use common\models\FullPrice;
use yii\helpers\Html;

$this->title = $header ? $header : 'Спецпредложения';
?>
<section class="special-catalog">
    <? if ($header): ?>
    <div class="special-catalog__title"><h2 <?= $headerColor ? 'style="color:'.$headerColor.';"' : '' ?>><?= $header ?></h2></div>
    <? endif; ?>
    <div class="special-catalog__container catalog-product">
    <? foreach ($models as $model): ?>
        <?= \common\components\helpers\CatalogHelper::getSpecialPageOfferHtml($model) ?>
    <? endforeach; ?>
    </div>
</section>
