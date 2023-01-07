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
use \common\components\helpers\CartHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$isEmpty = empty($cartItems = $cart->getItems());
$shopOrderForm = 'shop_order_form_1';
$payment = CartHelper::getCartDataByType('payment');
?>
<?php if(!$isEmpty): ?>

<?php $form = ActiveForm::begin([
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'enableClientScript' => false,
	'method' => 'post',
	'action' => Url::to(['/cart/'.\common\components\helpers\CartHelper::ACTIVE_ACTION_CONFIRMATION,]),
	'options' => ['name' => $shopOrderForm, 'class' => '',],
]); ?>
<!-- Cart payment section -->
<section class="cart-payment">
	<!-- title -->
	<h1 class="cart-payment__title">выберите способ оплаты</h1>

		<!-- tabs -->
		<div class="cart-payment__tabs">
		<?php
			foreach ($payment['children'] as $key => $paymentItem) {
				$payment_tabs[] = $paymentItem;
			}
			foreach ($payment_tabs as $key => $tabItem) {
		?>
		<input class="cart-payment__tab-input" id="cart-payment-tab-<?=$key + 1 ?>" type="radio" name="ShopOrder[settings_payment_type_id]" value="<?=$tabItem['id']?>" <?=$key == 0 ? 'checked' : ''?>>
		<label class="cart-payment__tab-label" for="cart-payment-tab-<?=$key + 1 ?>"><?=$tabItem['name']?></label>
		<?php
			}
		?>
		<!-- tabcontent -->
		<div class="cart-payment__tabcontent-inner">
			<?php 
				foreach ($payment_tabs as $key => $tabItem) {
			?>
			<div class="cart-payment__tabcontent-<?=$key+1?>">
				<?php if ($tabItem['is_active'] == true) { ?>
				<div class="cart-payment__tabcontent-wrapper">
					<?php 
						$variantsItems = [];
						if (!empty($tabItem['children'])) {
							foreach ($tabItem['children'] as $key => $variants) {
								if (!empty($variants)) {
									$variantsItems[] = $variants;
								}
							}
						}
					?>
					<?php 
					if(!empty($variantsItems)) {
						$isFirst = true;
						foreach ($variantsItems as $int => $variantsItem) {
							if (!empty($variantsItem['children']) and $variantsItem['is_active']) {
								foreach ($variantsItem['children'] as $key => $value) {
					?>
					<div class="cart-payment__option-inner">
						<!-- comment form -->
						<div class="cart-payment__option">

							<div class="cart-payment__option-info">
								<? if ($key < 1) { ?>
								<label class="cart-payment__option-info-title">
									<?	
										echo $variantsItem['name'];
									?>
								</label>
								<? } ?>
								<div class="cart-payment__option-info-wrapper">
									<div class="cart-payment__option-info-pic">
										<img src="/img/files/<?=$value['image']?>" alt="">
									</div>
									<div class="cart-payment__option-info-text">
										<?
											echo $value['name'];
										?>
									</div>
									<!-- <div class="cart-payment__option-info-payment-text">
										Доставка от <span>3</span> дней, от <span>350</span> <span style="font-size: 15px;" class="desktop-card-item__price"></span>

									</div> -->
								</div>
							</div>
							<div class="cart-payment__select-btn">
								<input type="radio" class="cart-payment__select-btn-radio" id="cart-payment__select-btn-card-<?=$value['id']?>" name="ShopOrder[settings_payment_id]" value="<?=$value['id']?>">
								<label for="cart-payment__select-btn-card-<?=$value['id']?>">
									<?
										echo $value['radio_text'];
									?>
								</label>
							</div>

						</div>

						<!-- info -->
						<div class="cart-payment__info cart-payment-info">
							<div class="cart-payment-info__description">
								<p> 
									<?
										echo $value['description'];
									?>
								</p>
							</div>
						</div>
					</div>
					<?php
								$isFirst = false;
								}
							}
						}
					}
					if ($tabItem['is_active'] == true) {
					?>
					<div class="cart-payment__notification-inner">
						<div class="cart-payment-next-step-btn__inner">

							<a class="cart-payment__next-step-btn cart-payment-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
								<div class="cart-payment-next-step-btn__text">далее к подтверждению заказа</div>
								<div class="cart-payment-next-step-btn__icon"></div>
							</a>

						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php 
					if ($tabItem['is_active'] == false) {
				?>
				<div class="cart-payment__payment-error cart-payment-error">
					<div class="cart-payment-error__inner">

						<div class="cart-payment-error__picture">
							<img src="/img/cart/cart-payment-error-pic.svg" alt="">
						</div>

						<div class="cart-payment-error__description-inner">

							<div class="cart-payment-error__description">выбранный вами способ оплаты недоступен</div>
							<div class="cart-payment-error__description">выберите <a class="cartPaymentSwitchBtn" href="">доступный способ оплаты</a></div>

						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<? } ?>
		</div>
	</div>
</section>
<?php ActiveForm::end(); ?>
<? else:?>
	<?= \common\components\helpers\CartHelper::renderEmptyCart() ?>
<? endif;?>

