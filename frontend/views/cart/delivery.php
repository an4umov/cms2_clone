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
$delivery = CartHelper::getCartDataByType('delivery');
?>
<?php if(!$isEmpty): ?>

<!-- Cart delivery section -->
<section class="cart-delivery">
	<!-- title -->
	<h1 class="cart-delivery__title">выберите способ доставки</h1>

	<!-- tabs -->
	<div class="cart-delivery__tabs">
		<?php 
			foreach ($delivery['children'] as $key => $deliveryItem) {
				$delivery_tabs[] = $deliveryItem;
			}
			foreach ($delivery_tabs as $key => $tabItem) {
				if ($tabItem['is_active'] == true) {
		?>
		<input class="cart-delivery__tab-input" id="cart-delivery-tab-<?=$key + 1 ?>" type="radio" name="ShopOrder[delivery_type_id]" value="<?=$tabItem['id']?>" <?=$key == 0 ? 'checked' : ''?>>
		<label class="cart-delivery__tab-label" for="cart-delivery-tab-<?=$key + 1 ?>"><?=$tabItem['name']?></label>
		<?php
				}
			}
		?>
		<!-- tabcontent -->
		<div class="cart-delivery__tabcontent-inner">
			<?php 
				$i = 1;
				foreach ($delivery_tabs as $key => $tabItem) {
					$shopOrderForm = 'shop_order_form_'.$i;
			?>
			<?php if ($tabItem['is_active'] == true) { ?>
			<div class="cart-delivery__tabcontent-<?=$i?>">
				<?php $form = ActiveForm::begin([
					'enableAjaxValidation' => false,
					'enableClientValidation' => false,
					'enableClientScript' => false,
					'method' => 'post',
					'action' => Url::to(['/cart/'.\common\components\helpers\CartHelper::ACTIVE_ACTION_PAYMENT,]),
					'options' => ['name' => $shopOrderForm, 'class' => '',],
				]); ?>
				<input class="cart-delivery__tab-input" type="hidden" name="ShopOrder[delivery_type_id]" value="<?=$tabItem['id']?>">
				<div class="cart-delivery__tabcontent-wrapper">
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
								foreach ($variantsItem['children'] as $k => $value) {
					?>
					<div class="cart-delivery__option-inner">
						<!-- comment form -->
						<div class="cart-delivery__option">

							<div class="cart-delivery__option-info">
								<? if ($k < 1) { ?>
								<label class="cart-delivery__option-info-title">
									<?	
										echo $variantsItem['name'];
									?>
								</label>
								<? } ?>
								<div class="cart-delivery__option-info-wrapper">
									<div class="cart-delivery__option-info-pic">
										<img style="width: 200px" src="/img/files/<?=$value['image']?>" alt="">
									</div>
									<div class="cart-delivery__option-info-text">
										<?
											echo $value['name'];
										?>
									</div>
									<!-- <div class="cart-delivery__option-info-payment-text">
										Доставка от <span>3</span> дней, от <span>350</span> <span style="font-size: 15px;" class="desktop-card-item__price"></span>

									</div> -->
								</div>
							</div>
							<div class="cart-delivery__select-btn">
								<input type="radio" class="cart-delivery__select-btn-radio" id="cart-delivery__select-btn-card-<?=$value['id']?>" name="ShopOrder[delivery_carrier_id]" value="<?=$value['id']?>">
								<label for="cart-delivery__select-btn-card-<?=$value['id']?>">
									<?
										echo $value['radio_text'];
									?>
								</label>
							</div>

						</div>

						<!-- info -->
						<div class="cart-delivery__info cart-delivery-info">
							<div class="cart-delivery-info__description">
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
					?>
					<? if ($key !== 0) { ?>
					<h2 class="cart-delivery-primary-data__title">Введите адрес доставки:</h2>
					<div class="cart-delivery__primary-data cart-delivery-primary-data">
						<ul class="cart-delivery-primary-data__inner">
							<? if ($key !== 1) { ?>
							<li class="cart-delivery-primary-data__input">
								<label for="city" class="cart-delivery-primary-data__input-title">Город</label>
								<?= Html::activeTextInput($shopOrder, 'delivery_city', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-delivery-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('delivery_city'),]);  ?>
							</li>
							<?php } ?>
							<li class="cart-delivery-primary-data__input">
								<label for="address" class="cart-delivery-primary-data__input-title">Адрес</label>
								<?= Html::activeTextInput($shopOrder, 'delivery_address', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-delivery-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('delivery_address'),]);  ?>
							</li>

							<li class="cart-delivery-primary-data__input">
								<label for="apartment" class="cart-delivery-primary-data__input-title">Квартира/Офис</label>
								<?= Html::activeTextInput($shopOrder, 'delivery_apartment', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-delivery-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('delivery_apartment'),]);  ?>
							</li>
							<? if ($key !== 1) { ?>
							<li class="cart-delivery-primary-data__input">
								<label for="index" class="cart-delivery-primary-data__input-title">Индекс</label>
								<?= Html::activeTextInput($shopOrder, 'delivery_index', ['type' => 'text', 'maxlength' => 255, 'class' => 'cart-delivery-primary-data__input-field', 'placeholder' => $shopOrder->getAttributeHint('delivery_index'),]);  ?>
							</li>
							<?php } ?>
						</ul>
					</div>
					<?php } ?>
					<div class="cart-delievery__notification-inner">
						<? if ($tabItem['description']) { ?>
						<div class="cart-delivery__notification cart-delivery-notification">
							<div class="cart-delivery-notification__icon"></div>
							<div class="cart-delivery-notification__description">
								<?=$tabItem['description'];?>
							</div>
						</div>
						<?php 
						}
						if ($tabItem['is_active'] == true) {
						?>
						<div class="cart-delivery-next-step-btn__inner">

							<a class="cart-delivery__next-step-btn cart-delivery-next-step-btn" onclick="cartFormSubmit('<?= $shopOrderForm ?>')">
								<div class="cart-delivery-next-step-btn__text">далее к оплате заказа</div>
								<div class="cart-delivery-next-step-btn__icon"></div>
							</a>

						</div>
						<? } ?>
					</div>
				</div>
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
							<div class="cart-payment-error__description">для оплаты измените <a>способ получения</a></div>
							<div class="cart-payment-error__description">или выберите другой способ оплаты</div>

						</div>
					</div>
				</div>
				<?php } ?>
				<?php ActiveForm::end(); ?>
			</div>
			<?php } ?>
			<? $i ++; } ?>
		</div>
	</div>
</section>
<? else:?>
	<?= \common\components\helpers\CartHelper::renderEmptyCart() ?>
<? endif;?>

