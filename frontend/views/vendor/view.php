<?php

use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\models\PriceList;
use common\models\Catalog;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->title = $model->title;

$images = CatalogHelper::scanCatalogImages($model->number);
if (!$images) {
    $images[] = '/img/'.Catalog::IMAGE_NOT_AVAILABLE_180;
}
if (count($breadcrumbs) > 1) {
    echo Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumbs',],
        'itemTemplate' => "<li>{link}</li>\n",
        'encodeLabels' => false,
        'homeLink' => [
            'label' => '',
            'url' => '/',
        ],
        'links' => $breadcrumbs,
    ]);
}
?>
<!--Single-offer-vendor-page-->
<section class="single-offer-vendor-page">

	<h1 class="single-offer-vendor-page__title"><?= $this->title ?></h1>
	<div class="single-offer-vendor-page__inner">
		<div class="single-offer-vendor-page__slider vendor-slider">
			<div class="vendor-slider__active-slide activeSlide">
				<div class="activeSlide__slider">
					<? foreach ($images as $img): ?>
						<div class="activeSlide__slider-item">
							<?= Html::img($img, ['alt' => '',]) ?>
						</div>
					<? endforeach; ?>
				</div>

				<div class="activeSlide__active-thumbnail"></div>
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
		<div class="single-offer-vendor-page__description single-vendor-description" style="height: auto;">
			<div class="single-vendor-description__vendor">
				Артикул: <span><?= $product->article_number ?></span> <br><br>
				Код товара: <span><?= $product->product_code ?></span> <br><br>
				Производитель: <span><?= $product->manufacturer ?></span>
			</div>
			<div class="single-vendor-description__text" style="min-height: unset;">
				<p>
					<b>Описание:</b><br>
					<?php 
                    	$description = nl2br(htmlentities($model->description, ENT_QUOTES, 'UTF-8'))
					?>
					<?= $description ?>
				</p>
				<div class="full-desktop-card__list">
					<div class="full-desktop-card__item desktop-card-item">
						<div class="desktop-card-item__inner" style="min-width: unset">
							<?php 
								if (!empty($product->commentary) or !empty($product->cross_type) or !empty($product->code) && $product['code'] === PriceList::CODE_PRICE_LR_RU) {
							?>
							<div class="desktop-card-item__properties desktop-properties" style="min-width: unset; width: 100%; padding-left: 0;">
								<div class="desktop-properties__icons">
									<div class="desktop-properties__states">
										<?=(!empty($product->commentary) ? '<div class="mobile-properties__state--attention"></div>' : '')?>
										<?=(!empty($product->cross_type) ? '<div class="mobile-properties__state--replacement"></div>' : '')?>
										<?=(!empty($product->code) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="mobile-properties__state--showroom"></div>' : '')?>
									</div>
								</div>
							</div>
							<?php 
								}
							?>
							<div class="desktop-card-item__price-inner" style="min-width: unset; width: 100%; padding-left: 0;">
								<div class="desktop-card-item__price"><?=CatalogHelper::formatPrice($product->price)?></div>
							</div>
							<div class="desktop-card-item__description desktop-description" style="min-width: unset; width: 100%; padding-left: 0; padding-right: 15px; white-space: nowrap;">
								<div class="desktop-description__shop"><?=$product->availability?> <span>шт</span></div>
							</div>
							<div class="desktop-card-item__buy desktop-buy" style="min-width: unset; width: 100%;">
								<a href="" class="desktop-buy__fast-buy-btn" title="Быстрая покупка" data-key="<?=$product->key?>" data-availability="<?=$product->availability?>">
									<div class="desktop-buy__fast-buy-btn-tooltip">Быстрая покупка</div>
								</a>
								<a href="" class="desktop-buy__buy-btn" style="margin-right: 30px;" data-key="<?=$product->key?>" data-availability="<?=$product->availability?>">
									<div class="desktop-buy__buy-btn-tooltip">Добавить в корзину</div>
								</a>
							</div>
						</div>
						<div class="desktop-card-item__info desktop-info" style="min-width: unset; width: 100%;">
							<div class="desktop-info__items">
								<div class="desktop-info__items-close" style="position: absolute;"></div>
								<div class="desktop-info__item desktop-info-item">
									<div class="desktop-info-item__title" style="padding-left: 20px; max-width: 75px;">
										<?=(!empty($product->commentary) ? '<div class="desktop-info-item__title--attention" style="margin-right: 10px;"></div>' : '')?>
										<?=(!empty($product->cross_type) ? '<div class="desktop-info-item__title--replacement" style="margin-right: 10px;"></div>' : '')?>
										<?=(!empty($product->code) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="desktop-info-item__title--showroom" style="margin-right: 10px;"></div>' : '')?>
									</div>
									<div class="desktop-info-item__text desktop-info-item__text--attention" style="text-align: left;"><?= $product->commentary ?><? if ($product['code'] === PriceList::CODE_PRICE_LR_RU) { ?>Товар имеется в шоу-руме LR.RU<? } ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="single-vendor-description__panel">
			
				<a href="#" class="single-vendor-description__panel--ask">
					<div class="single-vendor-description__panel--ask-tip">
						Задать вопрос
					</div>
				</a>
				<a href="#" class="single-vendor-description__panel--share">
					<div class="single-vendor-description__panel--share-tip">
						Поделиться
					</div>
				</a>
				<a class="single-vendor-description__panel--favorite">
					<div class="single-vendor-description__panel--favorite-tip">
						в Избранное
					</div>
				</a>
			</div>
		</div>
	</div>
	<?= \frontend\components\widgets\RelatedDocsWidget::widget(['number' => $model->number,]) ?>                   
</section>

<?= \frontend\components\widgets\RelatedProductsWidget::widget(['number' => $model->number,]) ?>

<?= \frontend\components\widgets\RelatedSectionsWidget::widget(['number' => $model->number,]) ?>

<?= \frontend\components\widgets\RelatedNewsWidget::widget(['number' => $model->number,]) ?>


