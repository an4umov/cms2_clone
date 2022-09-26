<?php

use common\components\helpers\CatalogHelper;
use yii\data\Pagination;
use \yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var array $data
 * @var array $data_noprice
 * @var string $title
 * @var string $title_noprice
 * @var string $number
 * @var bool $isPage
 * @var Pagination $pagination
 */
$class = $isPage ? 'offers-vendor-catalog-mobile' : 'offers-catalog-mobile';
$currentPageNumber = $pagination->page + 1;
$totalPageCount = $pagination->pageCount;
?>
<? if ($isPage && empty($data[$number]['products'])): ?>
    <!-- Блок с информацией об отсутствии товарных предложений -->
    <div class="single-offer-vendor-page__no-offers-info no-offers-info">
        <div class="no-offers-info__content">
            <div class="no-offers-info__first-paragraph">
                <img class="no-offers-info__picture" src="/img/offers/no-offers-info-pic.png" alt="no-offers">
                <p>к сожалению, сейчас нет ни одного предложения по данному товару</p>
            </div>
            <div class="no-offers-info__second-paragraph">
                вы можете отправить <a class="send-offer-request" href="#">запрос</a>, чтобы мы вам помогли подобрать аналоги
            </div>
        </div>
        <div class="no-offers-info__shadow"></div>
    </div>
<? else: ?>
    <section class="<?= $class ?>">
        <? if ($isPage): ?>
            <?= Html::tag('h2', $title, ['class' => 'offers-vendor-catalog-mobile__title',]) ?>
        <? else: ?>
            <?
                if (count($data) > 0) {
                    echo Html::tag('h1', $title);
                }
            ?>
        <? endif; ?>

        <? foreach ($data as $item): ?>
            <? if ($isPage): ?>
                <?= CatalogHelper::getCardProductMobilePageHtml($item) ?>
            <? else: ?>
                <?= CatalogHelper::getCardProductMobileHtml($item) ?>
            <? endif; ?>
        <? endforeach; ?>
        <?php if ($currentPageNumber == $totalPageCount): ?>
            <? if (!$isPage && $data_noprice): ?>
                <?= Html::tag('h1', $title_noprice) ?>
            <? endif; ?>
            <? foreach ($data_noprice as $item): ?>
                <? if (!$isPage): ?>
                    <!-- <div style="background: rgb(255 255 255 / 30%); position: absolute; max-width: 2000px; width: 100%; min-height: 550px; pointer-events: none; z-index: 100;"></div> -->
                    <?= CatalogHelper::getCardProductMobileHtml($item) ?>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>
    </section>
    <? $class = $isPage ? 'offers-vendor-catalog-desktop' : 'offers-catalog-desktop'; ?>
    <section class="<?= $class ?>">
        <? if (!$isPage): ?>
        <div class="offers-catalog-desktop__help">
            Кликнув по карточке товарного предложения можно перейти на страницу артикула
            <button class="offerCardDesktopHelpBtn">Понятно</button>
        </div>
        <? endif; ?>

        <? if ($isPage): ?>
            <?= Html::tag('h2', $title, ['class' => 'offers-vendor-catalog-desktop__title',]) ?>
        <? else: ?>
            <?
                if (count($data) > 0) {
                    echo Html::tag('h1', $title);
                }
            ?>
        <? endif; ?>
        <? foreach ($data as $item): ?>
            <? if ($isPage): ?>
                <?= CatalogHelper::getCardProductDesktopPageHtml($item) ?>
            <? else: ?>
                <?= CatalogHelper::getCardProductDesktopHtml($item) ?>
            <? endif; ?>
        <? endforeach; ?>

        <?php if ($currentPageNumber == $totalPageCount): ?>
            <? if (!$isPage && $data_noprice): ?>
                <?= Html::tag('h1', $title_noprice) ?>
            <? endif; ?>
            <? foreach ($data_noprice as $item): ?>
                <? if (!$isPage): ?>
                    <!-- <div style="background: rgb(255 255 255 / 30%); position: absolute; max-width: 2000px; width: 100%; min-height: 550px; pointer-events: none; z-index: 100;"></div> -->
                    <?= CatalogHelper::getCardProductDesktopHtml($item) ?>
                <? endif; ?>
            <? endforeach; ?>
        <? endif; ?>
    </section>
    <section class="pagination">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
            'prevPageCssClass' => 'pagination__prev-btn',
            'nextPageCssClass' => 'pagination__next-btn',

            'prevPageLabel' => '',
            'nextPageLabel' => '',
            'pageCssClass' => 'pagination__item',
            'linkContainerOptions' => [
                'class' => ''
            ],
            'linkOptions' => [
            ],
            'activePageCssClass' => 'pagination__item--active',
            'disabledPageCssClass' => '',
            'options' => [
                'class' => 'pagination__list',
            ]
        ]) ?>
    </section>
    <?php if ($currentPageNumber == $totalPageCount): ?>
        <div class="offers-catalog-next-wrapper">
            <a href="#" class="offers-catalog-next-btn">
                <div class="offers-catalog-next-btn__text">ДАЛЕЕ К РАЗДЕЛУ: <b></b></div>
                <div class="offers-catalog-next-btn__icon"></div>
            </a>
        </div>
    <? endif; ?>
<? endif; ?>