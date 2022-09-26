<?php
/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var $item \devanych\cart\CartItem
 * @var $activeAction string
 * @var $cartSettings array
 * @var $shopOrder ShopOrder
 */

use \common\components\helpers\CatalogHelper;
use \common\components\helpers\CartHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $cartSettings['name'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['activeAction'] = $activeAction;
$shopOrderForm = 'shop_order_form_1';

$cartImages = [];
$isEmpty = empty($cartItems = $cart->getItems());

foreach ($cartItems as $item) {
    $cartImages[$item->getId()] = Html::img('/img/'.Catalog::IMAGE_NOT_AVAILABLE_180);

    $images = CatalogHelper::scanCatalogImages($item->getProduct()->article_number);
    if ($images) {
        $image = array_shift($images);

        $cartImages[$item->getId()] = $image;
    }
}

$cartSettingsData = CartHelper::getCartDataByType('cart');
?>

<?php if(!$isEmpty): ?>

<?php 
$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'enableClientScript' => false,
    'method' => 'post',
    'action' => Url::to(['/cart/'.\common\components\helpers\CartHelper::ACTIVE_ACTION_CUSTOMER,]),
    'options' => ['name' => $shopOrderForm, 'class' => 'cart-customer-primary-data', 'style' => ['padding' => '0', 'margin' => '0', 'width' => '100%',],],
]); 
?>

<!-- Cart section -->
<section class="cart">
    <div class="cart__title-inner">
        <h1 class="cart__title"><?= $this->title ?></h1>
        <button class="cart__refresh-btn" type="button" onClick="window.location.href=window.location.href">обновить</button>
    </div>

    <!----------------- mobile products ---------------->

    <ul class="cart__mobile-products">
        <? foreach($cartItems as $item): ?>
        <? $product = $item->getProduct(); ?>
        <? $disabledClass = !empty($product->availability) ? '' : '-disabled'; ?>
        <? $isFavorite = \common\components\helpers\FavoriteHelper::isFavorite($product->article->number); ?>
            <!-- cart product -->
            <li class="cart__mobile-product cart-mobile-product<?= $disabledClass ?>" data-key="<?= $product->key ?>" data-availability="<?= $product->availability ?>">
                <!-- action -->
                <? if (empty($disabledClass)): ?>
                <div class="cart-mobile-product__action-inner">
                <? endif; ?>
                    <div class="cart-mobile-product__action">
                        <div class="cart-mobile-product__favorite-wrapper">
                            <div class="cart-mobile-product__favorite" data-key="<?= $product->article->number ?>">в избранное</div>
                            <div class="cart-mobile-product__favorite-active<?= $isFavorite ? ' cart-mobile-product__favorite-active--on' : '' ?>">в избранном</div>
                        </div>
                        <a class="cart-mobile-product<?= $disabledClass ?>__delete">убрать</a>
                    </div>
                <? if (empty($disabledClass)): ?>
                    <div class="cart-mobile-product__price">цена (шт):<p><?= CatalogHelper::formatPrice($item->getPrice()) ?></p></div>
                    </div>
                <? endif; ?>
                <!-- description -->
                <div class="cart-mobile-product<?= $disabledClass ?>__inner">
                    <div class="cart-mobile-product<?= $disabledClass ?>__picture">
                        <a href="<?= Url::to(['shop/code', 'code' => $product->product_code,])?>"><?= Html::img($cartImages[$item->getId()]) ?></a>
                    </div>
                    <div class="cart-mobile-product<?= $disabledClass ?>__description">
                        <div class="cart-mobile-product<?= $disabledClass ?>__description-inner">
                            <div class="cart-mobile-product<?= $disabledClass ?>__vendor-code">Артикул: <span><?= $product->article_number ?></span></div>
                            <div class="cart-mobile-product<?= $disabledClass ?>__manufactor"><?= $product->manufacturer ?></div>
                            <div class="cart-mobile-product<?= $disabledClass ?>__quality"><?= $product->quality ?></div>
                            <div class="cart-mobile-product<?= $disabledClass ?>__replacement"><img src="/img/cart/cart-replace-icon.svg" alt=""></div>
                        </div>
                        <!-- title -->
                        <div class="cart-mobile-product<?= $disabledClass ?>__title">
                            <a href="<?= Url::to(['shop/code', 'code' => $product->product_code,])?>"><?= $product->article->name ?></a>
                        </div>
                        <? if (empty($disabledClass)): ?>
                            <!-- delivery -->
                            <div class="cart-mobile-product__delivery">
                                <div class="cart-mobile-product__shop">lr.ru - <?= $product->availability ?> <? if (is_numeric($product->availability)): ?><span>шт</span><? endif; ?></div>
                                <div class="cart-mobile-product__delivery-info">Отгрузим через 2 дня</div>
                            </div>
                        <? else: ?>
                            <!-- change panel -->
                            <div class="cart-mobile-product<?= $disabledClass ?>__change">
                                <div class="cart-mobile-product<?= $disabledClass ?>__change-text">Товар закончился</div>
                                <a href="#" class="cart-mobile-product<?= $disabledClass ?>__change-btn">Подобрать похожие товары</a>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
                <? if (empty($disabledClass)): ?>
                    <!-- cost -->
                    <div class="cart-mobile-product__cost-inner">
                        <div class="cart-mobile-product__cost">стоимость:<p><?= CatalogHelper::formatPrice($item->getCost()) ?></p></div>
                        <div class="cart-mobile-product__quantity cart-mobile-product-quantity" style="display: none;">
                            <div class="cart-mobile-product-quantity__btn-minus"></div>
                            <input class="cart-mobile-product-quantity__default-input" placeholder="<?= $item->getQuantity() ?>">
                            <div class="cart-mobile-product-quantity__btn-plus"></div>
                        </div>
                        <!-- default-input -->
                        <div class="cart-mobile-product__quantity cart-mobile-product-quantity">

                            <div class="cart-mobile-product-quantity__btn-minus"></div>
                            <input class="cart-mobile-product-quantity__default-input" placeholder="<?= $item->getQuantity() ?>" type="number" maxlength="3">
                            <div class="cart-mobile-product-quantity__btn-plus"></div>

                        </div>
                    </div>
                <? endif; ?>
            </li>
            <div class="cart__mobile-product-separator"></div>
        <? endforeach; ?>
    </ul>

    <!--------------------------- DESKTOP PRODUCTS -------------------------------->

    <!-- desktop products -->
    <div class="cart__desktop-products">
        <!-- products panel -->
        <div class="cart__desktop-products-panel cart-desktop-products-panel">
            <div class="cart-desktop-products-panel__name">Наименование</div>
            <div class="cart-desktop-products-panel__price">Цена (<span>шт</span>)</div>
            <div class="cart-desktop-products-panel__quantity">Количество</div>
            <div class="cart-desktop-products-panel__cost">Стоимость</div>
            <div class="cart-desktop-products-panel__ghost"></div>
        </div>

        <!-- products -->
        <ul class="cart__desktop-products-inner">
            <? foreach($cartItems as $item): ?>
            <? $product = $item->getProduct(); ?>
            <? $disabledClass = !empty($product->availability) ? '' : '-disabled'; ?>
            <? 
                $counterStyle = '';
                if (is_numeric($product->availability) and $item->getQuantity() == $product->availability) {
                    $counterDisabledClass = 'cart-desktop-product-quantity__btn-plus cart-desktop-product-quantity__btn-plus--disable';
                    $counterStyle = 'style="pointer-events: none;"';
                } else {
                    $counterDisabledClass = 'cart-desktop-product-quantity__btn-plus';
                }
            ?>
            <? $isFavorite = \common\components\helpers\FavoriteHelper::isFavorite($product->article->number); ?>
            <!-- product -->
            <li class="cart__desktop-product cart-desktop-product<?= $disabledClass ?>" data-key="<?= $product->key ?>" data-availability="<?= $product->availability ?>">
                <div class="cart-desktop-product<?= $disabledClass ?>__description-inner">
                    <div class="cart-desktop-product<?= $disabledClass ?>__picture">
                        <a href="<?= Url::to(['shop/vendor', 'number' => $product->article_number,])?>" target="_blank"><?= Html::img($cartImages[$item->getId()]) ?></a>
                    </div>
                    <!-- product description -->
                    <div class="cart-desktop-product<?= $disabledClass ?>__description">
                        <!-- inner -->
                        <div class="cart-desktop-product<?= $disabledClass ?>__inner">
                            <div class="cart-desktop-product<?= $disabledClass ?>__vendor-code">Артикул: <span><?= $product->article_number ?></span></div>
                            <div class="cart-desktop-product<?= $disabledClass ?>__manufactor"><?= $product->manufacturer ?></div>
                            <div class="cart-desktop-product<?= $disabledClass ?>__quality"><?= $product->quality ?></div>
                            <div class="cart-desktop-product<?= $disabledClass ?>__replacement"><img src="/img/cart/cart-replace-icon.svg" alt=""></div>
                        </div>
                        <!-- title -->
                        <div class="cart-desktop-product<?= $disabledClass ?>__title">
                            <a href="<?= Url::to(['shop/vendor', 'number' => $product->article_number,])?>" target="_blank"><?= $product->article->name ?></a>
                        </div>

                        <? if (empty($disabledClass)): ?>
                            <!-- delivery -->
                            <div class="cart-desktop-product__delivery">
                                <div class="cart-desktop-product__shop">lr.ru - <?= $product->availability ?> <? if (is_numeric($product->availability)): ?><span>шт</span><? endif; ?></div>
                                <div class="cart-desktop-product__delivery-info">Отгрузим через 2 дня</div>
                            </div>
                        <? else: ?>
                            <!-- change-text -->
                            <div class="cart-desktop-product<?= $disabledClass ?>__change-text">
                                Товар закончился
                            </div>
                        <? endif; ?>
                    </div>
                </div>

                <? if (!empty($disabledClass)): ?>
                    <a href="#" class="cart-desktop-product<?= $disabledClass ?>__change-btn">Подобрать похожие товары</a>
                <? else: ?>
                    <!-- price -->
                    <div class="cart-desktop-product__price"><p><?= CatalogHelper::formatPrice($item->getPrice()) ?></p></div>
                    <!-- quantity -->
                    <div class="cart-desktop-product__quantity cart-desktop-product-quantity">
                        <div class="<?=($product->availability <= 1 ? 'cart-desktop-product-quantity__btn-minus cart-desktop-product-quantity__btn-minus--disable' : 'cart-desktop-product-quantity__btn-minus') ?>"></div>
                        <input class="cart-desktop-product-quantity__default-input" placeholder="<?= $item->getQuantity() ?>" <?=$counterStyle?>>
                        <div class="<?=$counterDisabledClass ?>"></div>
                    </div>
                    <!-- cost -->
                    <div class="cart-desktop-product__cost"><p><?//= CatalogHelper::formatPrice($item->getCost()) ?><?= CatalogHelper::formatPrice($item->getPrice() * $item->getQuantity()) ?></p></div>
                <? endif; ?>

                <!-- action -->
                <div class="cart-desktop-product<?= $disabledClass ?>__action">
                    <div class="cart-desktop-product__favorite-wrapper">
                        <div class="cart-desktop-product__favorite" data-key="<?= $product->article->number ?>"></div>
                        <div class="cart-desktop-product__favorite-active<?= $isFavorite ? ' cart-desktop-product__favorite-active--on' : ''?>"></div>
                    </div>
                    <div class="cart-desktop-product__delete"></div>
                </div>
            </li>
            <div class="cart__desktop-product-separator"></div>
            <? endforeach; ?>
        </ul>
    </div>

    <!-- mobile starter price -->
    <div class="cart__mobile-starter-price cart-mobile-starter-price">
        <!-- promocode-input + refresh btn -->
        <div class="cart-mobile-starter-price__panel">
            <!-- refresh btn -->
            <button class="cart-mobile-starter-price__refresh-btn" type="button" onClick="window.location.href=window.location.href">обновить</button>
        </div>
        <!-- starter cost -->
        <div class="cart-mobile-starter-price__cost">
            <div class="cart-mobile-starter-price__cost-title">всего:</div>
            <div class="cart-mobile-starter-price__cost-output"><?= CatalogHelper::formatPrice($cart->getTotalCost()) ?></div>
        </div>
    </div>

    <!-- desktop starter price -->
    <div class="cart__desktop-starter-price cart-desktop-starter-price">
        <!-- starter cost -->
        <div class="cart-desktop-starter-price__cost">
            <!-- refresh btn -->
            <button class="cart-desktop-starter-price__refresh-btn" type="button" onClick="window.location.href=window.location.href">обновить</button>
            <!-- title + output -->
            <div class="cart-desktop-starter-price__cost-inner">
                <div class="cart-desktop-starter-price__cost-title">всего:</div>
                <div class="cart-desktop-starter-price__cost-output"><?= CatalogHelper::formatPrice($cart->getTotalCost()) ?></div>
            </div>
        </div>
    </div>
    <!-- cargo + btns -->
    <div class="cart__cargo-inner">
        <div class="cart__cargo cart-cargo"></div>
        <!-- btns -->
        <div class="cart__btn-inner">
            <!-- next step btn -->
            <a class="cart__next-step-btn cart-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
                <div class="cart-next-step-btn__text">
                    <p>перейти к оформлению заказа:</p>
                    <p>Указать покупателя, способы получения и т.д.</p>
                </div>
                <div class="cart-next-step-btn__icon"></div>
            </a>
        </div>
    </div>
</section>
<?= Html::activeHiddenInput($shopOrder, 'is_need_installation', ['value' => intval($shopOrder->is_need_installation),]) ?>
<?php ActiveForm::end(); ?>
<? else:?>
    <?= \common\components\helpers\CartHelper::renderEmptyCart() ?>
<? endif;?>