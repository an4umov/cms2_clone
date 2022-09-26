<?php
/**
 * @var \yii\web\View $this
 * @var array $data
 * @var \common\models\Articles $model
 * @var \common\models\FullPrice $fullPriceModel
 * @var bool $isCatalogList
 * @var bool $isInCart
 * @var int $index
 */

use \common\components\helpers\CatalogHelper;
use \common\components\helpers\CartHelper;
use common\models\FullPrice;

$widgetID = 'article-item-list';
$this->params['isInCart'] = $isInCart;
?>

<div class="product_pred" id="block_id<?= $index ?>"<? if ($isCatalogList && !$isInCart): ?> style="display: none;"<? else: ?> style="display: block;"<? endif; ?>>
    <div class="container mycontainer">
        <? if (!$isCatalogList): ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="product_sort">
                    <div class="title_sort">товарные предложения</div>
                    <div class="sort1">Показывать <span>Все</span></div>
                    <div class="sort2">Сортировка <span>По цене</span> <i class="fas fa-sort-amount-down"></i></div>
                </div>
            </div>
        </div>
        <? endif; ?>

        <? foreach ($data as $shopTitle => $shopData): ?>
            <? if (!empty($shopData['list'])): ?>
            <div class="row marginlr">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h4 <?= !empty($shopData['color']) ? 'style="background-color: '.$shopData['color'].' !important;"' : '' ?>><?= $shopTitle ?></h4>
                </div>
            </div>
            <? foreach ($shopData['list'] as $fullPriceModel): ?>
                <div class="row table0">
                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 dop1">
                        <h5><?= $fullPriceModel->manufacturer ?></h5>
                        <? if ($fullPriceModel->quality): ?><span><?= $fullPriceModel->quality ?></span> <i class="fas fa-info-circle"></i><? endif; ?>
                    </div>

                    <?
                    $col1 = $col2 = $col3 = 1;
                    if (!$fullPriceModel->commentary) {
                        if (!$fullPriceModel->sale) {
                            $col2 = 3;
                        } else {
                            $col2 = 2;
                            if (!$fullPriceModel->isReplace) {
                                $col3 = 3;
                            }
                        }
                    } else {
                        if (!$fullPriceModel->sale) {
                            $col2 = 2;
                            if (!$fullPriceModel->isReplace) {
                                $col1 = 3;
                            }
                        } else {
                            if (!$fullPriceModel->isReplace) {
                                $col3 = 2;
                            } else {
                                $col1 = 3;
                            }
                        }
                    }

                    $countInCart = 1;
                    $isInCart = $fullPriceModel->isInCart();
                    if ($isInCart) {
                        $countInCart = $fullPriceModel->getCountInCart();
                    }
                    ?>

                    <? if ($fullPriceModel->commentary): ?>
                    <div class="col-12 col-sm-12 col-md-<?= $col1 ?> col-lg-<?= $col1 ?> col-xl-<?= $col1 ?> dop1">
                        <i class="fas fa-info-circle" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $fullPriceModel->commentary ?>"></i>
                    </div>
                    <? endif; ?>
                    <? if ($fullPriceModel->isReplace): ?>
                    <div class="col-12 col-sm-12 col-md-<?= $col2 ?> col-lg-<?= $col2 ?> col-xl-<?= $col2 ?> dop3">
                        Замена<br>
                        <span>ERR3340</span>
                    </div>
                    <? endif; ?>
                    <? if ($fullPriceModel->sale): ?>
                    <div class="col-12 col-sm-12 col-md-<?= $col3 ?> col-lg-<?= $col3 ?> col-xl-<?= $col3 ?> dop4">
                        <span><i class="fas fa-cog"></i> Лучшая цена</span>
                    </div>
                    <? endif; ?>

                    <? if (!$fullPriceModel->commentary && !$fullPriceModel->isReplace && !$fullPriceModel->sale): ?>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 dop4"></div>
                    <? endif; ?>

                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 dop4">
                        <div class="price"><?= is_numeric($fullPriceModel->price) ? number_format($fullPriceModel->price, 0, '.', ' ').' <i class="fas fa-ruble-sign"></i>' : $fullPriceModel->price ?></div>
                        <? if ($fullPriceModel->sale): ?><button type="button" style="<?= $fullPriceModel->sale_color ? 'background-color: '.$fullPriceModel->sale_color.' !important' : '' ?>">лучшая цена</button><? endif; ?>
                    </div>
                    <div class=" col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 dop5">
                        <?= CatalogHelper::getFullPriceDelivery($fullPriceModel) ?>
                    </div>
                    <div class="col-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 dop6">
                        <?= $fullPriceModel->availability ?><?= $fullPriceModel->availability ? ' ШТ' : '' ?>
                    </div>
                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 dop7">
                        <?= CartHelper::getCartButtons($fullPriceModel, $isInCart) ?>
                        <?= CartHelper::getCartPlusMinus($model, $fullPriceModel, $countInCart, !$isInCart) ?>
                    </div>
                </div>
            <? endforeach; ?>
            <? endif; ?>
        <? endforeach; ?>

        <? if (!$isCatalogList): ?>
        <?= \frontend\components\widgets\ArticleItemBreadcrumbsWidget::widget(['model' => $model,]); ?>
        <? endif; ?>
    </div>
</div>