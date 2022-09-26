<?php

/* @var $this \yii\web\View */
/* @var $content string */

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
$wpData = [];//AppHelper::getMainLayoutData();
$model = $this->params['searchModel'] ?? new SiteSearch();
$shop = $this->params['shop'] ?? DepartmentMenuWidget::ACTIVE_SHOP_ALL;
$menu = $this->params['menu'] ?? '';

$js = 'app.hideGalleryBlock()';
$this->registerJs($js, $this::POS_READY);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css"/>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="container mycontainer">
        <div class="row">
            <div class="col-3 col-sm-2 col-md-2 order-md-1 order-lg-1 order-xl-1 col-lg-1 col-xl-1">
                <div class="logo">
                    <a href="/"><img src="<?= $wpData[AppHelper::HEADER_KEY]['logo']['url'] ?? '/img/logo.svg' ?>" alt=""></a>
                </div>
            </div>
            <div class="col-9 col-sm-10 col-md-6 order-md-2 order-lg-2 order-xl-2 col-lg-4 col-xl-4">
                <div class="header_block1_top">
                    <div class="text">
                        <?= $wpData[AppHelper::HEADER_KEY]['slogan']['text'] ?? 'Мы доставляем по России и СНГ' ?>
                    </div>
                    <div class="lang">
                        <img src="/img/flag_ru.svg" alt="">ru
                    </div>
                </div>

                <?= \frontend\components\widgets\DepartmentMenuWidget::widget(['activeShop' => $shop,]); ?>

            </div>
            <div class="col-12 col-sm-8 col-md-12 order-md-4 order-lg-3 order-xl-3 col-lg-5 col-xl-5">
                <nav class="header_menu">
                    <ul>
                        <li class="li_color1"><a href="tel:<?= $wpData[AppHelper::HEADER_KEY]['phone_header']['phone_link'] ?? '+74956496060' ?>"><i class="fas fa-phone"></i> <?= $wpData[AppHelper::HEADER_KEY]['phone_header']['phone'] ?? '+7 (495) 649 60 60' ?></a></li>
                        <li><a href=""><i class="fas fa-comment"></i> поддержка</a></li>
                        <li><a href="<?= $wpData[AppHelper::HEADER_KEY]['callme_link'] ?? '' ?>"><i class="fas fa-phone-volume"></i> <?= $wpData[AppHelper::HEADER_KEY]['callme_header'] ?? 'заказать звонок' ?></a></li>
                        <li><a href="<?= $wpData[AppHelper::HEADER_KEY]['contacts_link'] ?? '' ?>"><i class="fas fa-address-card"></i> <?= $wpData[AppHelper::HEADER_KEY]['contacts_header'] ?? 'контакты' ?></a></li>
                    </ul>
                </nav>
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'method' => 'get',
                    'action' => Url::to(['/search',]),
                ]); ?>
                <div class="search_header">
                    <div class="input-group">
                        <? if ($shop !== DepartmentMenuWidget::ACTIVE_SHOP_ALL): ?>
                        <?= Html::hiddenInput('shop', $shop); ?>
                        <? endif; ?>
                        <?= $form->field($model, 'search', ['template' => '{input}', 'options' => ['tag' => false, 'style' => 'height: auto;',],])->textInput([
                            'placeholder' => Yii::t('app', 'поиск по артикулу или наименованию (минимум 4 символа)...'),
                            'class' => 'form-control', 'style' => 'height: 40px;',
                            'name' => 'search',
                        ])->label(false)->hint(false) ?>
                        <div class="input-group-append">
                            <button type="button" class="btn ext"><i class="fas fa-cogs"></i></button>
                            <button type="submit" class="btn btn-outline-secondary">найти</button>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-12 col-sm-4 col-md-4 order-md-3 order-lg-4 order-xl-4 col-lg-2 col-xl-2">
                <div class="cabinet">
                    <i class="fas fa-user"></i>
                    <a href="">Вход</a> / <a href=""> Регистрация</a>
                </div>
                <div class="fav_car">
                    <div class="favorite">
                        <div class="num">2</div>
                        <a href=""><i class="far fa-heart"></i></a>
                        <div class="text0">Избранное</div>
                    </div>
                    <div class="cart">
                        <div class="num"><?= \common\components\helpers\CartHelper::getCartItemsCount() ?></div>
                        <a href="/cart"><i class="fas fa-shopping-cart"></i></a>
                        <div class="text0">Корзина</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?//= \frontend\components\widgets\HeaderGreenMenuWidget::widget(['activeMenu' => $menu, 'shop' => $shop,]); ?>

<? if (!empty($this->params['breadcrumbs'])): ?>
<div class="container mycontainer">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="breadcrumb">
                <?= Breadcrumbs::widget([
                    'options' => ['class' => false,],
                    'itemTemplate' => "<li>{link}</li>\n",
                    'encodeLabels' => false,
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => '/',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
<? endif; ?>

<?= \common\widgets\Alert::widget(['isBackend' => false, 'view' => $this,]) ?>
<?php
Yii::$app->session->removeAllFlashes();
?>

<?php echo $content ?>

<footer>
    <div class="footer1">
        <div class="container mycontainer">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="logo_phone">
                        <div class="logo"><a href="/"><img src="<?= $wpData[AppHelper::FOOTER_KEY]['logo_footer']['url'] ?? '/img/logo.svg' ?>" alt=""></a></div>
                        <div class="phone">
                            <div class="p1"><i class="fas fa-phone"></i></div>
                            <div class="p2"><?= $wpData[AppHelper::FOOTER_KEY]['phone1_footer'] ?? '+7 (495) 649 60 60' ?><br><?= $wpData[AppHelper::FOOTER_KEY]['phone2_footer'] ?? '+7 (495) 649 60 60' ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 contact">
                    <ul>
                        <li><i class="fas fa-address-card"></i> <a href="<?= $wpData[AppHelper::FOOTER_KEY]['contacts_link'] ?? '' ?>"><?= $wpData[AppHelper::FOOTER_KEY]['contacts_footer'] ?? 'Контакты' ?></a></li>
                        <li><i class="fas fa-map-marked"></i> <a href="<?= $wpData[AppHelper::FOOTER_KEY]['directions_link'] ?? '' ?>"><?= $wpData[AppHelper::FOOTER_KEY]['directions'] ?? 'Схема проезда' ?></a></li>
                        <li><i class="fas fa-clock"></i> <a href="">График работы</a></li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 subscribe">
                    <h4><?= $wpData[AppHelper::FOOTER_KEY]['subscribe_title'] ?? 'Подпишитесь на нашу рассылку' ?></h4>
                    <p><?= $wpData[AppHelper::FOOTER_KEY]['subscribe_desc'] ?? 'для получения новостей подпишитесь' ?></p>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Ваш E-mail...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary"><i class="fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <button class="button1" data-url="<?= $wpData[AppHelper::FOOTER_KEY]['callme_link'] ?? '' ?>"><i class="fas fa-phone-volume"></i><?= $wpData[AppHelper::FOOTER_KEY]['callme_footer'] ?? 'Заказать звонок' ?></button>
                    <br>
                    <button class="button2" data-url="<?= $wpData[AppHelper::FOOTER_KEY]['onlinechat_link'] ?? '' ?>"><i class="fas fa-comments"></i><?= $wpData[AppHelper::FOOTER_KEY]['onlinechat'] ?? 'Онлайн чат' ?></button>
                    <br>
                    <button class="button3" data-url="<?= $wpData[AppHelper::FOOTER_KEY]['rev_link'] ?? '' ?>"><i class="fas fa-user-edit"></i><?= $wpData[AppHelper::FOOTER_KEY]['rev_footer'] ?? 'Отзывы, пожелания' ?></button>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="soc">
                        <? if (!empty($wpData[AppHelper::FOOTER_KEY]['social_footer'])): ?>
                        <ul>
                            <? foreach ($wpData[AppHelper::FOOTER_KEY]['social_footer'] as $social): ?>
                            <li><a href="<?= $social['link'] ?>"><i class="fab <?= $social['icon'] ?>"></i></a></li>
                            <? endforeach; ?>
                        </ul>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row footer_top_menu">
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>информация</h3>
                    <ul>
                        <li><a href="">О Компании</a></li>
                        <li><a href="">Реквизиты</a></li>
                        <li><a href="">Ваканции</a></li>
                        <li><a href="">Сотрудничество</a></li>
                        <li><a href="">Оптовикам</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>информация</h3>
                    <ul>
                        <li><a href="">О Компании</a></li>
                        <li><a href="">Реквизиты</a></li>
                        <li><a href="">Ваканции</a></li>
                        <li><a href="">Сотрудничество</a></li>
                        <li><a href="">Оптовикам</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>информация</h3>
                    <ul>
                        <li><a href="">О Компании</a></li>
                        <li><a href="">Реквизиты</a></li>
                        <li><a href="">Ваканции</a></li>
                        <li><a href="">Сотрудничество</a></li>
                        <li><a href="">Оптовикам</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>информация</h3>
                    <ul>
                        <li><a href="">О Компании</a></li>
                        <li><a href="">Реквизиты</a></li>
                        <li><a href="">Ваканции</a></li>
                        <li><a href="">Сотрудничество</a></li>
                        <li><a href="">Оптовикам</a></li>
                    </ul>
                </div>
            </div>

            <hr class="hr_martop_0 hide">
            <div class="row hide">
                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <h3>оглавление магазина</h3>
                    <ul>
                        <li><a href="">Пункт 1</a></li>
                        <li><a href="">Пункт 2</a></li>
                        <li><a href="">Пункт 3</a></li>
                        <li><a href="">Пункт 4</a></li>
                        <li><a href="">Пункт 5</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="footer2">
        © Copyright 2011-<?= date('Y') ?>. All rights is reserved
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
<?
$style = '
    nav.tags {
        -webkit-box-pack: end;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        float: right;
        width: 100%;
    }
    
    nav.tags .tag {
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 auto;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        display: block;
        padding: 10px 20px;
        margin: 0 10px 10px 0;
        border-radius: 3px;
        background-color: #6f7ebb;
        line-height: 1;
        color: #fff;
        text-decoration: none;
    }
    
    nav.tags .tag.active {
        background-color: #12236b;
    }
    
    nav.tags .tag:hover {
        background-color: #12236b;
    }
    
    a.last-news:hover {
        text-decoration: none;
    }
      
    div.shop1 img {
        width: 190px;
    }
    
    form div.form-group label.error {
        font-size: 12px;
        font-weight: 600;
        color: #E93333;
    }
';

echo  Html::style($style) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
