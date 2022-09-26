<?php

use common\components\helpers\CatalogHelper;
use \common\components\helpers\ContentHelper;
use common\models\Catalog;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $article
 * @var \common\models\Articles $model
 */

$this->title = $model->name;

$images = CatalogHelper::scanCatalogImages($model->number);
if (!$images) {
    $images[] = '/img/'.Catalog::IMAGE_NOT_AVAILABLE_180;
}


?>
<!--Single-offer-vendor-page-->
<section class="single-offer-vendor-page">
    <h1 class="single-offer-vendor-page__title"><?= $this->title ?></h1>
    <div class="single-offer-vendor-page__inner">
        <div class="single-offer-vendor-page__slider vendor-slider">
            <div class="vendor-slider__active-slide activeSlide">
                <div class="activeSlide__slider">
                    <? foreach ($images as $img) {
                        $size = CatalogHelper::catalogImagesSizes($img);
                        $imgFit = $sliderAlign = '';
                        $sliderAlign = 'justify-content: center;';
                        $imgStyles = ['object-fit' => 'contain', 'width' => '100%', 'height' => '100%'];
                        if ($size['width'] < 650) {
                            $imgStyles['object-fit'] = 'unset';
                            $imgStyles['width'] = 'auto';
                            $imgStyles['height'] = 'auto';
                        } else {
                            $imgStyles['width'] = '100%';
                        }
                        if ($size['height'] >= 450) {
                            $imgStyles['width'] = 'auto';
                            $imgStyles['height'] = '100%';
                        }
                        if ($size['width'] > 650) {
                            $imgStyles['width'] = '100%';
                            $imgStyles['height'] = '100%';
                        }
                    ?>
                        
                    <div class="activeSlide__slider-item"><?= Html::img($img, ['alt' => '', 'style' => $imgStyles]) ?></div>
                    <? } ?>
                </div>

                <div class="activeSlide__active-thumbnail" style="<?=$sliderAlign; ?>"></div>
                <div class="activeSlide__prev-slide"></div>
                <div class="activeSlide__next-slide"></div>
            </div>

            <div class="vendor-slider__inner">
                <div class="vendor-slider__thumbnails">
                    <div class="vendor-slider__thumbnails-inner"></div>
                    <div class="vendor-slider__control vendor-slider__control--prev"></div>
                    <div class="vendor-slider__control vendor-slider__control--next"> </div>
                </div>

            </div>
        </div>
        <div class="single-offer-vendor-page__description single-vendor-description">
            <div class="single-vendor-description__vendor">
                Артикул: <span><?= $model->number ?></span>
            </div>
            <div class="single-vendor-description__text">
                <?= $model->description ?>
            </div>
            <div class="single-vendor-description__panel">
                <?= ContentHelper::generatePanelAskButton() ?>
                <?= ContentHelper::generatePanelShareButton() ?>
                <?= ContentHelper::generatePanelFavoriteButton() ?>
            </div>
        </div>
    </div>
    <?= \frontend\components\widgets\RelatedDocsWidget::widget(['number' => $model->number,]) ?>
</section>

<?= \frontend\components\widgets\ProductOffersWidget::widget(['title' => 'Товарные предложения', 'number' => $model->number, 'isPage' => true,]) ?>

<?= \frontend\components\widgets\RelatedProductsWidget::widget(['number' => $model->number,]) ?>

<?= \frontend\components\widgets\RelatedSectionsWidget::widget(['number' => $model->number,]) ?>

<?= \frontend\components\widgets\RelatedNewsWidget::widget(['number' => $model->number,]) ?>


