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
    <div class="no-offers-info-banner">
        <div class="no-offers-info-banner__title">
            к сожалению, сейчас нет ни одного предложения по данному товару
        </div>
        <div class="no-offers-info-banner__inner">
            <div class="no-offers-info-banner__image">
                <img src="/img/no-offer-new-illustration.svg" alt="">
            </div>
            <div class="no-offers-info-banner__wrapper">
                <div class="no-offers-info-banner__info">
                    Чтобы мы помогли подобрать аналоги, Вы можете
                </div>
                <a class="no-offers-info-banner__btn"> Отправить запрос </a>
            </div>
        </div>
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
    </section>
    <? $class = $isPage ? 'offers-vendor-catalog-desktop' : 'offers-catalog-desktop'; ?>
    <section class="<?= $class ?>">
        <? if (!$isPage): ?>
        <div class="offers-catalog-desktop__help">
            Кликнув по карточке товарного предложения можно перейти на страницу артикула
            <button class="offerCardDesktopHelpBtn">Понятно</button>
        </div>
        <? endif; ?>
        <? 
            foreach ($data as $item) { 
                if (!$isPage && $item['price'] == 0) {
                    $dataCount = count($item);
                    $n = 0;
                } else {
                    $p = 0;
                }
            } 
        ?>
        <? if ($isPage) { ?>
            <?= Html::tag('h2', $title, ['class' => 'offers-vendor-catalog-desktop__title',]) ?>
        <? } ?>
        <? foreach ($data as $item): ?>
            <? 
                if (count($data) > 0) {
                    if ($item['price'] == 0) { 
                        if ($n == 0) {
                            echo Html::tag('h1', $title_noprice);
                        }
                        $n++;
                    } else {
                        if (!$isPage) {
                            if ($p == 0) {
                                echo Html::tag('h1', $title);
                            }
                            $p++;
                        }
                    }
                }
            ?>
            <? if ($isPage): ?>
                <?= CatalogHelper::getCardProductDesktopPageHtml($item) ?>
            <? else: ?>
                <?= CatalogHelper::getCardProductDesktopHtml($item) ?>
            <? endif; ?>
        <? endforeach; ?>
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
    <?php if (Yii::$app->controller->id == 'catalog' && $currentPageNumber == $totalPageCount && !$isPage): ?>
        <div class="offers-catalog-next-wrapper">
            <a href="#" class="offers-catalog-next-btn">
                <div class="offers-catalog-next-btn__text">ДАЛЕЕ К РАЗДЕЛУ: <b></b></div>
                <div class="offers-catalog-next-btn__icon"></div>
            </a>
        </div>
    <? endif; ?>
<? endif; ?>