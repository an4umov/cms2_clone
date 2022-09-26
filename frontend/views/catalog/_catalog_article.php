<?php

use common\components\helpers\CatalogHelper;
use frontend\components\widgets\ArticleItemsWidget;
use \yii\helpers\Html;

/* @var \common\models\Articles $model
 * @var \yii\web\View $this
 * @var int $index
 */
$index += 1;
$image = '';
$images = CatalogHelper::scanCatalogImages($model->number);
if ($images) {
    $image = array_shift($images);
}

$fullPriceSale = $model->getFullPriceSale();
?>
<div class="oneproduct1">
    <div class="border00">
        <? if ($fullPriceSale): ?>
        <div class="special_label00" style="<?= $fullPriceSale->sale_color ? 'background-color: '.$fullPriceSale->sale_color.' !important' : '' ?>"><?= $fullPriceSale->sale ?></div>
        <? endif; ?>
        <? if (CatalogHelper::isHasFullPriceInStock($model)): ?>
            <div class="label_instock">В наличии !</div>
        <? endif; ?>
        <div class="col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2" style="min-height: 180px;">
            <? if ($image): ?>
            <?= Html::a(Html::img($image, ['class' => 'img-fluid',]), ['/shop/code', 'code' => $model->number,]) ?>
            <? endif; ?>
        </div>
        <div class="row align-items-center col-12 col-sm-12 col-md-8 col-lg-10 col-xl-10">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-10">
                <h4><span class="color1"><?= Html::a($model->number, ['/shop/code', 'code' => $model->number,]) ?></span>&nbsp; <?= Html::a($model->name, ['/shop/code', 'code' => $model->number,]) ?></h4>
                <p><?= $model->description ?></p>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-2">
                <div class="price">
                    <div class="price_title">Цена от:</div>
                    <span class="price_p"><?= number_format(CatalogHelper::getArticleMinPrice($model), 0, '.', ' ') ?> <i class="fas fa-ruble-sign"></i></span>
                </div>
                <button type="button" class="readmore_price">Все цены <i class="fas fa-chevron-down"></i></button>
            </div>
        </div>
    </div>
    <?= ArticleItemsWidget::widget(['model' => $model, 'isCatalogList' => true, 'index' => $index,]); ?>
</div>
