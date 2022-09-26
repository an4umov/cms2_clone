<?php
/**
 * @var $this yii\web\View
 * @var array $models
 * @var string $header
 * @var string $headerColor
 * @var int $bid
 * @var int $contentID
 * @var bool $isShowAllButton
 * @var bool $isSlider
 */
?>
<? if ($isSlider): ?>
    <section class="special-container">
        <? if ($header): ?>
        <div class="special-container__title">
            <h2 <?= $headerColor ? 'style="color:'.$headerColor.';"' : '' ?>><?= $header ?></h2>
            <? if ($isShowAllButton && $contentID): ?>
                <a class="watch-all-btn" href="<?= \common\components\helpers\ContentHelper::getContentUrl($contentID) ?>">Смотреть все</a>
            <? endif; ?>
        </div>
        <? endif; ?>
        <div class="special-slider js-special-slider">
            <div class="special-slider__items js-special-slider__items">
                <? foreach ($models as $model): ?>
                <?= \common\components\helpers\CatalogHelper::getSpecialOfferHtml($model) ?>
                <? endforeach; ?>
            </div>
            <? if (count($models) && $isSlider): ?>
            <div class="special-slider__control special-slider__control--previous js-special-slider__previous"></div>
            <div class="special-slider__control special-slider__control--next js-special-slider__next"></div>
            <? endif; ?>
        </div>
    </section>
<? else: ?>
    <section class="special-catalog">
        <? if ($header): ?>
        <div class="special-catalog__title">
            <h2<?= $headerColor ? ' style="color:'.$headerColor.';"' : '' ?>><?= $header ?></h2>
            <? if ($isShowAllButton && $contentID): ?>
                <a class="watch-all-btn" href="<?= \common\components\helpers\ContentHelper::getContentUrl($contentID) ?>">Смотреть все</a>
            <? endif; ?>
        </div>
        <? endif; ?>
        <div class="special-catalog__container special-offer-catalog">
            <? foreach ($models as $model): ?>
                <?= \common\components\helpers\CatalogHelper::getSpecialPageOfferHtml($model) ?>
            <? endforeach; ?>
        </div>
    </section>
<? endif; ?>