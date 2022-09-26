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

use \common\models\PriceList;
use \common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$shopOrderForm = 'shop_order_form_1';
$isEmpty = empty($cartItems = $cart->getItems());
?>

<?php if(!$isEmpty): ?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'enableClientScript' => false,
    'method' => 'post',
    'action' => Url::to(['/cart/'.\common\components\helpers\CartHelper::ACTIVE_ACTION_DELIVERY,]),
    'options' => ['name' => $shopOrderForm, 'class' => '',],
]); ?>

<!-- personal data autocomplete banner - ADDITION for Cart-personal section -->
<div class="personal-data-autocomplete">
    <div class="personal-data-autocomplete__inner">
        <div class="personal-data-autocomplete__picture">
            <img src="/img/personal-data-autocomplete-pic.svg" alt="">
        </div>
        <div class="personal-data-autocomplete__description-inner">
            <div class="personal-data-autocomplete__description">Мы используем COOKIE, если вы уже заполняли формы, то автоматически данные взяты оттуда.</div>
            <!-- <div class="personal-data-autocomplete__description">в личном кабинете вы можете <a href="<?//= Yii::$app->params['cabinetHostUrl'] ?>">изменить свои данные</a></div> -->
        </div>
    </div>
</div>

<!-- Cart-personal section -->
<section class="cart-customer">
    <div class="cart-customer__title-inner">
        <? if (Yii::$app->user->isGuest): ?>
            <!-- <div class="cart-customer__enter">Уже покупали у нас ранее? <a href="<?//= Yii::$app->params['cabinetHostUrl'] ?>">Войдите в личный кабинет</a></div> -->
        <? endif; ?>
        <h1 class="cart-customer__title">данные покупателя</h1>
    </div>
    <ul class="cart-customer-primary-data__inner">
        <li class="cart-customer-primary-data__input">
            <label class="cart-customer-primary-data__input-title" for="name"><?= $shopOrder->getAttributeLabel('name')?></label>
            <?= Html::activeTextInput($shopOrder, 'name', ['type' => 'text', 'maxlength' => 150, 'class' => 'cart-customer-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('name'),]);  ?>
        </li>
        <li class="cart-customer-primary-data__input">
            <label class="cart-customer-primary-data__input-title" for="email"><?= $shopOrder->getAttributeLabel('email')?></label>
            <?= Html::activeTextInput($shopOrder, 'email', ['type' => 'email', 'maxlength' => 150, 'class' => 'cart-customer-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('email'),]);  ?>
        </li>
        <li class="cart-customer-primary-data__input">
            <label class="cart-customer-primary-data__input-title" for="phone"><?= $shopOrder->getAttributeLabel('phone')?></label>
            <?= Html::activeTextInput($shopOrder, 'phone', ['type' => 'tel', 'maxlength' => 150, 'class' => 'cart-customer-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('phone'),]);  ?>
        </li>
    </ul>

    <!-- tabs -->
    <div class="cart-customer__tabs">
        <?= Html::activeRadio($shopOrder, 'user_type', ['id' => 'cart-customer-tab-1', 'class' => 'cart-customer__tab-input', 'value' => ShopOrder::USER_TYPE_PRIVATE_PERSON, 'checked' => $shopOrder->user_type === ShopOrder::USER_TYPE_PRIVATE_PERSON, 'label'=> false, 'uncheck' => false,]);  ?>
        <label class="cart-customer__tab-label" for="cart-customer-tab-1">покупатель - физичеcкое лицо</label>

        <?= Html::activeRadio($shopOrder, 'user_type', ['id' => 'cart-customer-tab-2', 'class' => 'cart-customer__tab-input', 'value' => ShopOrder::USER_TYPE_LEGAL_PERSON, 'checked' => $shopOrder->user_type === ShopOrder::USER_TYPE_LEGAL_PERSON, 'label'=> false, 'uncheck' => false,]);  ?>
        <label class="cart-customer__tab-label" for="cart-customer-tab-2">покупатель -  юридическое лицо или ип</label>

        <div class="cart-customer__tabcontent-inner">
            <!-- tabcontent 1 -->
            <div class="cart-customer__tabcontent-1">
                <div class="cart-customer-next-step-btn__inner">
                    <a class="cart-customer__next-step-btn cart-customer-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
                        <div class="cart-customer-next-step-btn__text">далее к выбору способов доставки</div>
                        <div class="cart-customer-next-step-btn__icon"></div>
                    </a>
                </div>
            </div>
            <!-- tabcontent 2 -->
            <div class="cart-customer__tabcontent-2">
                <!-- radio btns -->
                <div class="cart-customer__radio-btns">
                    <?= Html::activeRadio($shopOrder, 'legal_type', ['id' => 'cart-customer-radio-btn-1', 'class' => 'cart-customer__radio-btn-input', 'checked' => $shopOrder->legal_type === ShopOrder::LEGAL_TYPE_IP, 'value' => ShopOrder::LEGAL_TYPE_IP, 'label'=> false, 'uncheck' => false,]);  ?>
                    <label class="cart-customer__radio-btn-label" for="cart-customer-radio-btn-1">Индивидуальный предприниматель</label>

                    <?= Html::activeRadio($shopOrder, 'legal_type', ['id' => 'cart-customer-radio-btn-2', 'class' => 'cart-customer__radio-btn-input', 'checked' => $shopOrder->legal_type === ShopOrder::LEGAL_TYPE_COMPANY, 'value' => ShopOrder::LEGAL_TYPE_COMPANY, 'label'=> false, 'uncheck' => false,]);  ?>
                    <label class="cart-customer__radio-btn-label" for="cart-customer-radio-btn-2">Фирма, юридическое лицо</label>

                    <div class="cart-customer__radio-btn-content-inner">
                        <!-- radio btn content 1 -->
                        <div class="cart-customer__radio-btn-content-1">
                            <!-- form organisation data -->
                            <ul class="cart-customer-organisation-data__inner">
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_inn')?></label>
                                    <p class="cart-customer-organisation-data__input-hint">Введите ИНН, и мы найдем Вашу организацию</p>
                                    <?= Html::activeTextInput($shopOrder, 'legal_inn', ['type' => 'text', 'pattern' => '[0-9]', 'maxlength' => 12, 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-inn', 'placeholder' => $shopOrder->getAttributeHint('legal_inn'),]);  ?>
                                </li>
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_organization_name')?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_organization_name', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-organization-name', 'placeholder' => $shopOrder->getAttributeHint('legal_organization_name'),]);  ?>
                                </li>
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_address')?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_address', ['type' => 'text', 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-address', 'placeholder' => $shopOrder->getAttributeHint('legal_address'),]);  ?>
                                </li>
                            </ul>

                            <?= Html::activeRadio($shopOrder, 'legal_payment', ['id' => 'cart-customer-radio-btn-3', 'class' => 'cart-customer__radio-btn-input', 'checked' => $shopOrder->legal_payment === ShopOrder::LEGAL_PAYMENT_BANK_TRANSFER, 'value' => ShopOrder::LEGAL_PAYMENT_BANK_TRANSFER, 'label'=> false, 'uncheck' => false,]);  ?>
                            <label class="cart-customer__radio-btn-label" for="cart-customer-radio-btn-3"><?= $shopOrder->getAttributeLabel('legal_payment')?></label>

                            <!-- payment details data -->
                            <ul class="cart-customer-payment-details-data__inner" style="margin-bottom: 25px;">
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_bik') ?></label>
                                    <p class="cart-customer-payment-details-data__input-hint cart-customer-payment-details-data__input-hint-bik">Введите БИК, и мы найдем Ваш банк</p>
                                    <?= Html::activeTextInput($shopOrder, 'legal_bik', ['type' => 'text', 'maxlength' => 9, 'pattern' => '[0-9]', 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-bik', 'placeholder' => $shopOrder->getAttributeHint('legal_bik'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_bank') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_bank', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-bank', 'placeholder' => $shopOrder->getAttributeHint('legal_bank'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_correspondent_account') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_correspondent_account', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-correspondent-account', 'placeholder' => $shopOrder->getAttributeHint('legal_correspondent_account'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_payment_account') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_payment_account', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('legal_payment_account'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_comment') ?></label>
                                    <?= Html::activeTextarea($shopOrder, 'legal_comment', ['class' => 'cart-customer-payment-details-data__input-textarea', 'placeholder' => $shopOrder->getAttributeHint('legal_comment'),]);  ?>
                                </li>
                            </ul>
                            <div class="cart-customer-next-step-btn__inner">
                                <a class="cart-customer__next-step-btn cart-customer-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
                                    <div class="cart-customer-next-step-btn__text">далее к выбору способов доставки</div>
                                    <div class="cart-customer-next-step-btn__icon"></div>
                                </a>
                            </div>
                        </div>

                        <!-- radio btn  content 2 -->
                        <div class="cart-customer__radio-btn-content-2">
                            <!-- form organisation data -->
                            <ul class="cart-customer-organisation-data__inner">
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_inn')?></label>
                                    <p class="cart-customer-organisation-data__input-hint">Введите ИНН, и мы найдем Вашу организацию</p>
                                    <?= Html::activeTextInput($shopOrder, 'legal_inn', ['type' => 'text', 'pattern' => '[0-9]', 'maxlength' => 10, 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-inn', 'placeholder' => $shopOrder->getAttributeHint('legal_inn'),]);  ?>
                                </li>
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_kpp')?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_kpp', ['type' => 'text', 'maxlength' => 30, 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-kpp', 'placeholder' => $shopOrder->getAttributeHint('legal_kpp'),]);  ?>
                                </li>
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_organization_name')?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_organization_name', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-organization-name', 'placeholder' => $shopOrder->getAttributeHint('legal_organization_name'),]);  ?>
                                </li>
                                <li class="cart-customer-organisation-data__input">
                                    <label class="cart-customer-organisation-data__input-title"><?= $shopOrder->getAttributeLabel('legal_address')?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_address', ['type' => 'text', 'class' => 'cart-customer-organisation-data__input-field cart-customer-organisation-data__input-address', 'placeholder' => $shopOrder->getAttributeHint('legal_address'),]);  ?>
                                </li>
                            </ul>

                            <?= Html::activeRadio($shopOrder, 'legal_payment', ['id' => 'cart-customer-radio-btn-3', 'class' => 'cart-customer__radio-btn-input', 'checked' => $shopOrder->legal_payment === ShopOrder::LEGAL_PAYMENT_BANK_TRANSFER, 'value' => ShopOrder::LEGAL_PAYMENT_BANK_TRANSFER, 'label'=> false, 'uncheck' => false,]);  ?>
                            <label class="cart-customer__radio-btn-label" for="cart-customer-radio-btn-3"><?= $shopOrder->getAttributeLabel('legal_payment')?></label>

                            <!-- payment details data -->
                            <ul class="cart-customer-payment-details-data__inner" style="margin-bottom: 25px;">
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_bik') ?></label>
                                    <p class="cart-customer-payment-details-data__input-hint cart-customer-payment-details-data__input-hint-bik">Введите БИК, и мы найдем Ваш банк</p>
                                    <?= Html::activeTextInput($shopOrder, 'legal_bik', ['type' => 'text', 'pattern' => '[0-9]', 'maxlength' => 9, 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-bik', 'placeholder' => $shopOrder->getAttributeHint('legal_bik'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_bank') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_bank', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-bank', 'placeholder' => $shopOrder->getAttributeHint('legal_bank'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_correspondent_account') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_correspondent_account', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field cart-customer-payment-details-data__input-correspondent-account', 'placeholder' => $shopOrder->getAttributeHint('legal_correspondent_account'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_payment_account') ?></label>
                                    <?= Html::activeTextInput($shopOrder, 'legal_payment_account', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-customer-payment-details-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('legal_payment_account'),]);  ?>
                                </li>
                                <li class="cart-customer-payment-details-data__input">
                                    <label class="cart-customer-payment-details-data__input-title"><?= $shopOrder->getAttributeLabel('legal_comment') ?></label>
                                    <?= Html::activeTextarea($shopOrder, 'legal_comment', ['class' => 'cart-customer-payment-details-data__input-textarea', 'placeholder' => $shopOrder->getAttributeHint('legal_comment'),]);  ?>
                                </li>
                            </ul>

                            <div class="cart-customer-next-step-btn__inner">
                                <a class="cart-customer__next-step-btn cart-customer-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
                                    <div class="cart-customer-next-step-btn__text">далее к выбору способов доставки</div>
                                    <div class="cart-customer-next-step-btn__icon"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- recommended banner of installation service - ADDITION for CART section -->
<div class="recommended-installation-service">
    <div class="recommended-installation-service__inner">
        <div class="recommended-installation-service__picture"></div>
        <div class="recommended-installation-service__description-inner">
            <div class="recommended-installation-service__title">ТРЕБУЕТСЯ УСЛУГА ПО УСТАНОВКЕ ПРИОБРЕТЕННЫХ ДЕТАЛЕЙ?</div>
            <div class="recommended-installation-service__text">Наш Сервисный центр и Магазин запчастей работают каждый день с 9.00 до 20.00 ПН-СБ <br>
                У нас две зоны ожидания, одна напротив телевизоров, транслирующих он-лайн картинку сервиса, а опднявшись по лестнице, вы окажетесь в приватной зоне на балконе шоурума. Здесь вы можете отдохнуть и даже вздремнуть. Бесплатный WiFi, несколько сортов чая и зерновой кофе.
            </div>
            <div class="recommended-installation-service__btn-inner">
                <?= Html::activeHiddenInput($shopOrder, 'is_need_installation', ['value' => intval($shopOrder->is_need_installation),]) ?>
                <a href="#" class="recommended-installation-service__btn">установить детали</a>

                <a href="#" class="recommended-installation-service__link">Подробнее о сервисе</a>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<? else:?>
    <?= \common\components\helpers\CartHelper::renderEmptyCart() ?>
<? endif;?>

