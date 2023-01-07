<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\components\helpers\FavoriteHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\components\helpers\AppHelper;
use frontend\models\search\SiteSearch;
use \common\components\helpers\CatalogHelper;
use \frontend\components\widgets\DepartmentMenuWidget;

AppAsset::register($this);
$searchModel = $this->params['searchModel'] ?? new SiteSearch();
$shop = $this->params[AppHelper::TEMPLATE_KEY_SHOP] ?? DepartmentMenuWidget::ACTIVE_SHOP_ALL;
$shopMenu = $this->params[AppHelper::TEMPLATE_KEY_SHOP_MENU] ?? '';
$shopMenuTag = $this->params[AppHelper::TEMPLATE_KEY_SHOP_MENU_TAG] ?? '';

$greenMenuActive = $this->params[AppHelper::GREEN_MENU_ACTIVE] ?? '';

$headerSettings = AppHelper::getHeaderSettings();

$isGuest = Yii::$app->user->isGuest;
$displayName = $isGuest ? 'Гость' : Yii::$app->user->getDisplayName();
$cartCount = \common\components\helpers\CartHelper::getCartItemsCount();
$favoriteCount = count(FavoriteHelper::list());
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
    <header class="header">
        <!-- header mobile -->
        <div class="header-mobile">
            <!-- logo mobile -->
            <a href="/" class="header-mobile__logo">
                <img src="<?= $headerSettings['image'] ?>" alt="">
            </a>
            <!-- search panel mobile -->
            <div class="header-mobile__search-panel search-panel-mobile">
                <div class="search-panel-mobile__user-location">
                    Мы доставляем в ваш город: <span></span>
                </div>

                <?= Html::beginForm(Url::to(['/search',]), 'get', ['class' => 'search-panel-mobile__search search-mobile',]); ?>
                <? if ($shop !== DepartmentMenuWidget::ACTIVE_SHOP_ALL): ?>
                    <?= Html::hiddenInput('shop', $shop); ?>
                <? endif; ?>
                <?= Html::activeTextInput($searchModel, SiteSearch::TEXT, ['tag' => false, 'name' => SiteSearch::TEXT, 'class' => 'search-mobile__input', 'placeholder' => 'Введите запрос..', 'required' => 'true']);
                ?>
                <button class="search-mobile__setting toggle-settings" type="button"></button>
                <button class="search-mobile__submit" type="submit"></button>
                <div class="search__modal-wrapper">
                    <div class="search__modal">
                        <div class="search__modal-header">
                            <b>Настройка поиска</b>
                            Ищем в:
                        </div>
                        <div class="search__modal-body">
                            <input type="checkbox" id="search__input-name-mobile" class="search__input-checkbox" name="search_in_name" checked readonly disabled="disabled">
                            <label for="search__input-name-mobile">Наименовании запчасти</label>
                            <input type="checkbox" id="search__input-article-mobile" class="search__input-checkbox" name="search_in_article">
                            <label for="search__input-article-mobile">Номере запчасти (Артикуле)</label>
                            <button class="search__modal-close" type="submit">OK</button>
                        </div>
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
            <!-- right panel mobile -->
            <div class="header-mobile__right-panel right-panel">
                <div class="right-panel__info">
                    <?= $headerSettings['phone'] ?>
                </div>
                <div class="right-panel__user user-mobile">
                    <a href="/favorite" class="user-mobile__favorites">
                        <img src="/img/favorites-icon.svg" alt="">
                        <span><?= $favoriteCount ?></span>
                    </a>
                    <a href="/cart" class="user-mobile__shopping-cart">
                        <img src="/img/shopping-cart-icon.svg" alt="">
                        <span><?= $cartCount ?></span>
                    </a>
                    <div class="user-mobile__wrapper user-wrapper">
                        <div class="user-wrapper__hidden-btn">
                            <a class="hidden-btn__icon" >
                                <span class="hb-line line-1"></span>
                                <span class="hb-line line-2"></span>
                                <span class="hb-line line-3"></span>
                            </a>
                        </div>
                        <!-- hidden menu -->
                        <div class="user-wrapper__hidden-menu hidden-menu">
                            <ul class="hidden-menu__links">
                                <!-- <li class="hidden-menu__link hidden-menu__link--enter"><a href="#">Вход</a></li> -->
                                <li class="hidden-menu__link"><a href="#">Faq</a></li>
                                <li class="hidden-menu__link"><a href="#">Контакты</a></li>
                            </ul>
                            <a href="#" class="hidden-menu__call-btn">
                                позвонить
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header desktop -->
        <div class="header-desktop">
            <!-- logo desktop -->
            <a href="/" class="header-desktop__logo">
                <img src="<?= $headerSettings['image'] ?>" alt="">
            </a>
            <!-- search panel desktop -->
            <div class="header-desktop__search-panel search-panel">
                <div class="search-panel__user-location">
                    Мы доставляем в ваш город: <span></span>
                </div>
                <?= Html::beginForm(Url::to(['/search',]), 'get', ['class' => 'search-panel__search search',]); ?>
                <? if ($shop !== DepartmentMenuWidget::ACTIVE_SHOP_ALL): ?>
                    <?= Html::hiddenInput('shop', $shop); ?>
                <? endif; ?>
                <?= Html::activeTextInput($searchModel, SiteSearch::TEXT, ['tag' => false, 'name' => SiteSearch::TEXT, 'class' => 'search__input', 'placeholder' => 'Введите запрос..', 'required' => true]);
                /*
                $form->field($model, 'search', ['template' => '{input}', 'options' => ['tag' => false,],])->textInput([
                    'placeholder' => Yii::t('app', 'поиск по артикулу или наименованию...'),
                    'class' => 'search-input',
                    'name' => 'search',
                ])->label(false)->hint(false)*/
                ?>
                <button class="search__setting toggle-settings" type="button"></button>
                <button class="search__submit" type="submit"></button>
                <div class="search__modal-wrapper">
                    <div class="search__modal">
                        <div class="search__modal-header">
                            <b>Настройка поиска</b>
                            Ищем в:
                        </div>
                        <div class="search__modal-body">
                            <input type="checkbox" id="search__input-name" class="search__input-checkbox" name="search_in_name" checked readonly disabled="disabled">
                            <label for="search__input-name">Наименовании запчасти</label>
                            <input type="checkbox" id="search__input-article" class="search__input-checkbox" name="search_in_article">
                            <label for="search__input-article">Номере запчасти (Артикуле)</label>
                            <button class="search__modal-close" type="submit">OK</button>
                        </div>
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
            <!-- user desktop -->
            <div class="header-desktop__user user">
                <a class="user__favorites" href="/favorite">
                    <img src="/img/favorites-icon.svg" alt="">
                    <p>Избранное</p>
                    <span><?= $favoriteCount ?></span>
                </a>
                <a class="user__shopping-cart" href="/cart">
                    <img src="/img/shopping-cart-icon.svg" alt="">
                    <p>Корзина</p>
                    <span><?= $cartCount ?></span>
                </a>
            </div>
            <!-- contacts desktop -->
            <div class="header-desktop__contacts contacts">
                <div class="contacts__links">
                    <a href="#" class="contacts__link">FAQ</a>
                    <a href="#" class="contacts__link">Контакты</a>
                </div>
                <div class="contacts__numbers">
                    <a href="#" class="contacts__number"><?= $headerSettings['phone'] ?></a>
                    <a href="#" class="contacts__number"><?= $headerSettings['phone'] ?></a>
                </div>
            </div>
        </div>
        <!-- header modal Contact Us -->
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

    <?= \frontend\components\widgets\HeaderGreenMenuNewWidget::widget(['activeMenu' => $greenMenuActive,]); ?>

    <main class="page-body__main">
        <?//= \frontend\components\widgets\HeaderGreenSubMenuWidget::widget(['shop' => $shop, 'activeModel' => $shopModel, 'activeMenu' => $shopModelMenu, 'activeTag' => $shopModelMenuTag,]); ?>

        <?= \common\widgets\Alert::widget(['isBackend' => false, 'view' => $this,]) ?>
        <? Yii::$app->session->removeAllFlashes() ?>

        <?= $content ?>
    </main>

    <?= $this->render('_footer', ['headerSettings' => $headerSettings,]) ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>