<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\components\helpers\FavoriteHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\components\helpers\AppHelper;
use \common\components\helpers\CartHelper;
use frontend\models\search\SiteSearch;
use \frontend\components\widgets\DepartmentMenuWidget;

AppAsset::register($this);

$headerSettings = AppHelper::getHeaderSettings();
$isGuest = Yii::$app->user->isGuest;
$displayName = $isGuest ? 'Гость' : Yii::$app->user->getDisplayName();
$cartCount = CartHelper::getCartItemsCount();
$favoriteCount = count(FavoriteHelper::list());
$activeAction = $this->params['activeAction'] ?? CartHelper::ACTIVE_ACTION_INDEX;
$disabledMobileClass = $disabledDesktopClass = '';

// $disabledMobileClass = ($cartCount !== 0) ? '' : 'header-cart-mobile__nav-item--disabled';
// $disabledDesktopClass = ($cartCount !== 0) ? '' : 'header-cart-desktop__nav-item--disabled';
if ($cartCount == 0) {
	$disabledMobileClass = 'header-cart-mobile__nav-item--disabled';
	$disabledDesktopClass = 'header-cart-desktop__nav-item--disabled';
}
$cartData = CartHelper::getCartSettingTreeData()[0];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
	<meta charset="<?php echo Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo Html::csrfMetaTags() ?>
	<title><?php echo Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<link rel="preload" href="/font/open-sans-v18-latin-300.woff2" as="font" crossorigin>
	<link rel="preload" href="/font/open-sans-v18-latin-800.woff2" as="font" crossorigin>
</head>
<body class="page-body">
<?php $this->beginBody() ?>
<div class="page-body__container">
	<!-- Header cart -->
	<header class="header-cart">
		<!-- header cart mobile -->
		<div class="header-cart-mobile">
			<!-- logo -->
			<a href="/" class="header-cart-mobile__logo">
				<img src="<?= $headerSettings['image'] ?>" alt="">
			</a>
			<div class="header-cart-mobile__inner">
				<!-- info -->
				<div class="header-cart-mobile__info">
					<!-- location -->
					<div class="header-cart-mobile__user-location">
						Мы доставляем в ваш город: <span></span>
					</div>
					<!-- phone -->
					<div class="header-cart-mobile__phone">
						<?= $headerSettings['phone'] ?>
					</div>
				</div>
				<!-- panel -->
				<div class="header-cart-mobile__panel">
					<!-- navigation -->
					<ul class="header-cart-mobile__nav-list">
						<?php 
						
							foreach ($cartData['children'] as $key => $value) {
								$shopOrderForm = 'shop_order_form_';
								if ($value['type'] == 'cart') {
									$type = 'index';
									$urlType = '';
								} else {
									$urlType = $type = $value['type'];
								}
								if ($value['is_active']) {
						?>
						<li class="header-cart-mobile__nav-item <?= $activeAction === $type ? 'header-cart-mobile__nav-item--current' : '' ?><?= $disabledDesktopClass ?>">
							<a href="/cart/<?=$urlType?>" data-form="shop_order_form_1" <? if (!empty($urlType)) { ?>onclick="cartFormSubmit('', this)"<? } ?>><?=$value['name']?></a>
						</li>
						<?php } } ?>
					</ul>
					<!-- user -->
					<div class="header-cart-mobile__user">
						<a href="/favorite" class="header-cart-mobile__favorites">
							<img src="/img/favorites-icon.svg" alt="">
							<span><?= $favoriteCount ?></span>
						</a>
						<a href="" class="header-cart-mobile__shopping-cart">
							<img src="/img/shopping-cart-icon.svg" alt="">
							<span><?= $cartCount ?></span>
						</a>
						<div class="header-cart-mobile__hamburger">
							<div class="header-cart-mobile__hamburger-btn">
								<a class="header-cart-mobile__hamburger-btn-icon">
									<span class="hbc-line line-1"></span>
                                	<span class="hbc-line line-2"></span>
                                	<span class="hbc-line line-3"></span>
								</a>
							</div>
							<div class="header-cart-mobile__hamburger-menu">
								<!-- <div class="header-cart-mobile__hamburger-enter"><a href="#">Вход</a></div> -->
								<ul class="header-cart-mobile__hamburger-links">
									<li class="header-cart-mobile__hamburger-link"><a href="#">Faq</a></li>
									<li class="header-cart-mobile__hamburger-link"><a href="#">Контакты</a></li>
								</ul>
								<a href="#" class="header-cart-mobile__hamburger-call-btn">позвонить</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- header cart desktop -->
		<div class="header-cart-desktop">
			<!-- logo -->
			<a href="/" class="header-cart-desktop__logo">
				<img src="<?= $headerSettings['image'] ?>" alt="">
			</a>
			<div class="header-cart-desktop__inner">
				<!-- info -->
				<div class="header-cart-desktop__info">
					<!-- location -->
					<div class="header-cart-desktop__user-location">
						Мы доставляем в ваш город: <span></span>
					</div>
					<div class="header-cart-desktop__info-wrapper">
						<!-- phone -->
						<ul class="header-cart-desktop__phone">
							<li class="header-cart-desktop__number"><a><?= $headerSettings['phone'] ?></a></li>
							<li class="header-cart-desktop__number"><a><?= $headerSettings['phone2'] ?></a></li>
						</ul>
						<!-- links -->
						<ul class="header-cart-desktop__links">
							<li class="header-cart-desktop__link"><a href="#">FAQ</a></li>
							<li class="header-cart-desktop__link"><a href="#">Контакты</a></li>
						</ul>
					</div>
				</div>
				<!-- panel -->
				<div class="header-cart-desktop__panel">
					<!-- navigation -->
					<ul class="header-cart-desktop__nav-list">
						<?php 
							foreach ($cartData['children'] as $key => $value) {
								if ($value['type'] == 'cart') {
									$type = 'index';
									$urlType = '';
								} else {
									$urlType = $type = $value['type'];
								}
								if ($value['is_active']) {
						?>
						<li class="header-cart-desktop__nav-item <?= $activeAction === $type ? 'header-cart-desktop__nav-item--current' : '' ?><?= $disabledDesktopClass ?>">
							<a href="/cart/<?=$urlType?>" data-form="shop_order_form_1" <? if (!empty($urlType)) { ?>onclick="cartFormSubmit('', this)"<? } ?>><?=$value['name']?></a>
						</li>
						<?php } } ?>
					</ul>
					<!-- user -->
					<div class="header-cart-desktop__user">
						<a href="/favorite" class="header-cart-desktop__favorites">
							<img src="/img/favorites-icon.svg" alt="">
							<span><?= $favoriteCount ?></span>
							<p>Избранное</p>
						</a>
						<a href="/cart" class="header-cart-desktop__shopping-cart">
							<img src="/img/shopping-cart-icon.svg" alt="">
							<span><?= $cartCount ?></span>
							<p>Корзина</p>
						</a>
						<!-- <a href="" class="header-cart-desktop__enter">
							<img src="/img/enter-icon.svg" alt="">
							<p>Вход</p>
						</a> -->
					</div>
				</div>
			</div>
		</div>

		<div class="header-contact-us">
            <div class="header-contact-us__blur"></div>
            <div class="header-contact-us__wrapper">
                <div class="header-contact-us__close"></div>
                <div class="header-contact-us__title">
                    Связаться с нами
                </div>
                <div class="header-contact-us__subtitle">
                    По телефону:
                </div>
                <ul class="header-contact-us__numbers">
                    <li class="header-contact-us__number">
                        <a href="tel:+74956496060"><?= $headerSettings['phone'] ?></a>
                    </li>
                    <li class="header-contact-us__number">
                        <a href="tel:+74956496060"><?= $headerSettings['phone'] ?></a>
                    </li>
                </ul>
                <div class="header-contact-us__subtitle">
                    В мессенджерах:
                </div>
                <ul class="header-contact-us__app-links">
                    <li class="header-contact-us__app-link header-contact-us__app-link--whatsapp">
                        <a href=""></a>
                    </li>
                    <li class="header-contact-us__app-link header-contact-us__app-link--telegram">
                        <a href=""></a>
                    </li>
                </ul>
            </div>
        </div>
	</header>

	<?= \common\widgets\Alert::widget(['isBackend' => false, 'view' => $this,]) ?>
	<? Yii::$app->session->removeAllFlashes() ?>

	<?= $content ?>

	<?= $this->render('_footer', ['headerSettings' => $headerSettings,]) ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
