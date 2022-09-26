<?php
/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var $item \devanych\cart\CartItem
 * @var $activeAction string
 * @var $cartSettings array
 * @var $shopOrder ShopOrder
 */

$this->title = $cartSettings['name'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['activeAction'] = $activeAction;

use \common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\helpers\CartHelper;

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
$shopOrderForm = 'shop_order_form_1';
$errors = \Yii::$app->session->getFlash('errors')[0];
?>

<?php if(!$isEmpty): ?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'enableClientScript' => false,
    'method' => 'post',
    'action' => Url::to(['/cart/'.\common\components\helpers\CartHelper::ACTIVE_ACTION_CONFIRMATION,]),
    'options' => ['name' => $shopOrderForm, 'class' => 'cart-customer-primary-data', 'style' => ['padding' => '0', 'margin' => '0', 'width' => '100%',],],
]); ?>

<?= Html::hiddenInput('confirmation', 1);  ?>

<!-- Cart-confirmation -->
<section class="cart-confirmation">
    <!-- title + reload-btn BLOCK FROM CART.HTML -->
    <div class="cart__title-inner" style="width: 800px">
        <h1 class="cart__title">Проверка информации</h1>
        <a href="/cart" class="cart__refresh-btn" style="min-width: 300px; background-position: 7% 50%;">Изменить состав Корзины</a>
    </div>
    <!-- mobile products -->
    <ul class="cart__mobile-products">
        <? foreach($cartItems as $item): ?>
        <? $product = $item->getProduct(); ?>
        <!-- cart product -->
        <li class="cart__mobile-product cart-mobile-product" data-key="<?= $product->key ?>" data-availability="<?= $product->availability ?>">
            <!-- description -->
            <div class="cart-mobile-product__inner">
                <div class="cart-mobile-product__picture">
                    <a href="<?= Url::to(['shop/vendor', 'number' => $product->product_code,])?>"><?= Html::img($cartImages[$item->getId()]) ?></a>
                </div>
                <div class="cart-mobile-product__description">
                    <div class="cart-mobile-product__description-inner">
                        <div class="cart-mobile-product__vendor-code">Артикул: <span><?= $product->article_number ?></span></div>
                        <div class="cart-mobile-product__manufactor"><?= $product->manufacturer ?></div>
                    </div>
                    <!-- title -->
                    <div class="cart-mobile-product__title">
                        <?= $product->article->name ?>
                    </div>
                    <!-- delivery -->
                    <div class="cart-mobile-product__delivery">
                        <div class="cart-mobile-product__shop">lr.ru - <?= $product->availability ?> <? if (is_numeric($product->availability)): ?><span>шт</span><? endif; ?></div>
                    </div>
                </div>
            </div>
            <!-- cost -->
            <div class="cart-mobile-product__cost-inner">
                <div class="cart-mobile-product__cost">стоимость:<p><?= CatalogHelper::formatPrice($item->getCost()) ?></p></div>
            </div>
        </li>
        <div class="cart__mobile-product-separator"></div>
        <? endforeach; ?>
    </ul>
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
        <ul class="cart-confirmation__desktop-products-inner">
            <? foreach($cartItems as $item): ?>
            <? $product = $item->getProduct(); ?>
            <!-- product -->
            <li class="cart-confirmation__desktop-product cart-confirmation-desktop-product" data-key="<?= $product->key ?>" data-availability="<?= $product->availability ?>">
                <div class="cart-confirmation-desktop-product__description-inner">
                    <div class="cart-confirmation-desktop-product__picture">
                        <a href="<?= Url::to(['shop/vendor', 'number' => $product->article_number,])?>" target="_blank"><?= Html::img($cartImages[$item->getId()]) ?></a>
                    </div>
                    <!-- product description -->
                    <div class="cart-confirmation-desktop-product__description">
                        <!-- inner -->
                        <div class="cart-confirmation-desktop-product__inner">
                            <div class="cart-confirmation-desktop-product__vendor-code">Артикул: <span><?= $product->article_number ?></span></div>
                            <div class="cart-confirmation-desktop-product__manufactor"><?= $product->manufacturer ?></div>
                            <div class="cart-confirmation-desktop-product__quality"><?= $product->quality ?></div>
                            <div class="cart-confirmation-desktop-product__replacement"><img src="/img/cart/cart-replace-icon.svg" alt=""></div>
                        </div>
                        <!-- title -->
                        <div class="cart-confirmation-desktop-product__title">
                            <?= $product->article->name ?>
                        </div>
                        <!-- delivery -->
                        <div class="cart-confirmation-desktop-product__delivery">
                            <div class="cart-confirmation-desktop-product__shop">lr.ru - <?= $product->availability ?> <? if (is_numeric($product->availability)): ?><span>шт</span><? endif; ?></div>
                            <div class="cart-confirmation-desktop-product__delivery-info">Отгрузим через 2 дня</div>
                        </div>
                    </div>
                </div>
                <!-- price -->
                <div class="cart-confirmation-desktop-product__price"><p><?= CatalogHelper::formatPrice($item->getPrice()) ?></p></div>
                <!-- quantity -->
                <div class="cart-confirmation-desktop-product__quantity cart-desktop-product-quantity">
                    <p><?= $item->getQuantity() ?></p>
                </div>
                <!-- cost -->
                <div class="cart-confirmation-desktop-product__cost"><p><?= CatalogHelper::formatPrice($item->getCost()) ?></p></div>
                <!-- action -->
                <div class="cart-desktop-product__action"></div>
            </li>
            <div class="cart-confirmation__desktop-product-separator"></div>
            <? endforeach; ?>
        </ul>
    </div>
    <!-- desktop starter price -->
    <div class="cart__desktop-starter-price cart-desktop-starter-price">
        <!-- starter cost -->
        <div class="cart-desktop-starter-price__cost">
            <!-- refresh btn -->
            <button class="cart-desktop-starter-price__refresh-btn">обновить</button>
            <!-- title + output -->
            <div class="cart-desktop-starter-price__cost-inner">
                <div class="cart-desktop-starter-price__cost-title">всего:</div>
                <div class="cart-desktop-starter-price__cost-output"><?= CatalogHelper::formatPrice($cart->getTotalCost()) ?></div>
            </div>
        </div>
    </div>
    <!-- confirmation details -->
    <div class="cart-confirmation__details">
        <!-- customer -->
        <div class="cart-confirmation__customer cart-confirmation-customer">
            <div class="cart-confirmation-customer__title">Покупатель</div>
            <ul class="cart-confirmation-customer__table">
                <li class="cart-confirmation-customer__row">
                    <div class="cart-confirmation-customer__row-title">Имя:</div>
                    <div class="cart-confirmation-customer__row-value">
                        <?
                            if ($shopOrder->name) {
                                echo $shopOrder->name;
                            } else {
                                echo 'Нашему менеджеру нужно знать как к Вам обращаться, <a href="/cart/customer" style="color: #EE7203;">укажите имя</a>';
                            }
                        ?>
                    </div>
                </li>
                <li class="cart-confirmation-customer__row">
                    <div class="cart-confirmation-customer__row-title">Email:</div>
                    <div class="cart-confirmation-customer__row-value">
                        <?
                            if ($shopOrder->email) {
                                echo $shopOrder->email;
                            } else {
                                echo 'Вы не <a href="/cart/customer" style="color: #EE7203;">указали почту</a>, на нее мы отправим Вам всю информацию по заказу';
                            }
                        ?>
                    </div>
                </li>
                <li class="cart-confirmation-customer__row">
                    <?php 
                        if ($shopOrder->phone) {
                    ?>
                    <div class="cart-confirmation-customer__row-title">Телефон:</div>
                    <div class="cart-confirmation-customer__row-value"><?= $shopOrder->phone ?></div>
                    <?php } ?>
                </li>
                <li class="cart-confirmation-customer__row">
                    <div class="cart-confirmation-customer__row-title">Статус:</div>
                    <div class="cart-confirmation-customer__row-value"><?= $shopOrder->getUserTypeTitle($shopOrder->user_type) ?></div>
                </li>
            </ul>
            <a href="/cart/<?= CartHelper::ACTIVE_ACTION_CUSTOMER ?>" class="cart-confirmation-customer__button">изменить данные покупателя</a>
        </div>
        <!-- delivery -->
        <div class="cart-confirmation__delivery cart-confirmation-delivery">
            <div class="cart-confirmation-delivery__title">Способ получения</div>
            <ul class="cart-confirmation-delivery__table">
                <li class="cart-confirmation-delivery__row">
                    <div class="cart-confirmation-delivery__row-title">Тип получения:</div>
                    <div class="cart-confirmation-delivery__row-value">
                        <?
                            if ($shopOrder->delivery_type_name) {
                                echo $shopOrder->delivery_type_name;
                            } else {
                                echo 'Укажите как и куда доставлять в разделе <a href="/cart/delivery" style="color: #EE7203;">получение</a>';
                            }
                        ?>
                    </div>
                </li>
                <?php 
                    if ($shopOrder->delivery_type_name and !str_contains($shopOrder->delivery_type_name, 'Самовывоз')) {
                ?>
                <li class="cart-confirmation-delivery__row">
                    <div class="cart-confirmation-delivery__row-title">Компания перевозчик:</div>
                    <div class="cart-confirmation-delivery__row-value">
                        <?
                            if ($shopOrder->delivery_carrier_name) {
                                echo $shopOrder->delivery_carrier_name;
                            } else {
                                echo 'Не указан';
                            }
                        ?>
                    </div>
                </li>
                <li class="cart-confirmation-delivery__row">
                    <div class="cart-confirmation-delivery__row-title">Адрес:</div>
                    <div class="cart-confirmation-delivery__row-value">
                        <?
                            if ($shopOrder->delivery_city or $shopOrder->delivery_index or $shopOrder->delivery_address or $shopOrder->delivery_apartment) {
                                if ($shopOrder->delivery_city) {
                                    echo $shopOrder->delivery_city;
                                }
                                if ($shopOrder->delivery_index) {
                                    echo '/ '.$shopOrder->delivery_index;
                                }
                                if ($shopOrder->delivery_address) {
                                    echo '/ '.$shopOrder->delivery_address;
                                }
                                if ($shopOrder->delivery_apartment) {
                                    echo ', '.$shopOrder->delivery_apartment;
                                }
                            } else {
                                echo "Заполните поля: город и адрес доставки";
                            }
                        ?> 
                    </div>
                </li>
                <? } ?>
            </ul>
            <a href="/cart/<?= CartHelper::ACTIVE_ACTION_DELIVERY ?>" class="cart-confirmation-delivery__button">изменить способ получения</a>
        </div>
        <!-- payment -->
        <div class="cart-confirmation__payment cart-confirmation-payment">
            <div class="cart-confirmation-payment__title">Способ оплаты</div>
            <p class="cart-confirmation-payment__value">
                <?
                    if ($shopOrder->payment_type_name) {
                        echo $shopOrder->payment_type_name;
                    } else {
                        echo "Не указан способ оплаты";
                    }
                ?>
            </p>
            <p class="cart-confirmation-payment__value">
                <?
                    if ($shopOrder->payment_name) {
                        echo $shopOrder->payment_name;
                    }
                ?>
            </p>
            <a href="/cart/<?= CartHelper::ACTIVE_ACTION_PAYMENT ?>" class="cart-confirmation-payment__button">изменить способ оплаты</a>
        </div>
    </div>
    <!-- send order btn-inner -->
    <div class="cart-confirmation__comment-inner">
        <!-- comment form -->
        <div class="cart-confirmation__input">
            <label class="cart-confirmation__input-title"><?= $shopOrder->getAttributeLabel('comment') ?></label>
            <?= Html::activeTextarea($shopOrder, 'comment', ['class' => 'cart-confirmation__input-textarea', 'placeholder' => $shopOrder->getAttributeHint('comment'),]);  ?>
        </div>
        <!-- send order btn -->
        <?php if ($errors):?>
            <a class="cart-confirmation__send-order-btn cart-confirmation-send-order-btn--disabled">
                <div class="cart-confirmation-send-order-btn__text">все верно, отправить заказ!</div>
                <div class="cart-confirmation-send-order-btn__icon--disabled"></div>
                <div class="cart-confirmation-send-order-btn--disabled-tip">
                    Для отправки заказа
                    <ul>
                        <? foreach ($errors as $error):?>
                        <li><?=$error?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </a>
        <?php else: ?>
            <a class="cart-confirmation__send-order-btn cart-confirmation-send-order-btn" onclick="cartFormSubmit('<?=$shopOrderForm?>')">
                <div class="cart-confirmation-send-order-btn__text">все верно, отправить заказ!</div>
                <div class="cart-confirmation-send-order-btn__icon"></div>
            </a>        
        <?php endif; ?>        
    </div>
</section>
<?php ActiveForm::end(); ?>
<? else:?>
    <?= \common\components\helpers\CartHelper::renderEmptyCart() ?>
<? endif;?>

