<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\LrAsset;
use yii\widgets\Breadcrumbs;
use common\components\helpers\AppHelper;
use frontend\models\search\LrPartsSearch;

LrAsset::register($this);

$searchModel = $this->params['searchModel'] ?? new LrPartsSearch();
$searchSettings = $this->params['searchSettings'] ?? '';
$headerSettings = AppHelper::getHeaderSettings();
//$isGuest = Yii::$app->user->isGuest;
//$displayName = $isGuest ? 'Гость' : Yii::$app->user->getDisplayName();
//$cartCount = CartHelper::getCartItemsCount();
//$favoriteCount = count(FavoriteHelper::list());
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
    <link rel="preload" href="/font/open-sans-v18-latin-300.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="/font/open-sans-v18-latin-800.woff2" as="font" crossorigin="anonymous">
</head>
<body class="page-body">
<?php $this->beginBody() ?>
<div class="page-body__container">
    <!-- header catalog -->
    <header class="header-catalog">
        <!-- logo -->
        <a href="/" class="header-catalog__logo">
            <img src="https://final.lr.ru<?= $headerSettings['image'] ?>" alt="">
        </a>
        <!-- header wrapper -->
        <div class="header-catalog__wrapper">
            <!-- title -->
            <div class="header-catalog__title">
                Каталоги запчастей
            </div>
            <!-- search panel -->
            <div class="header-catalog__search-panel search-panel">
                <?= Html::beginForm(Url::to(['/search',]), 'POST', ['class' => 'search-panel__search search',]); ?>
                <?= Html::activeTextInput($searchModel, LrPartsSearch::TEXT, ['tag' => false, 'name' => LrPartsSearch::TEXT, 'class' => 'search__input', 'placeholder' => 'Поиск по артикулу или наименованию...',]); ?>
                <button class="search__setting searchModalToggle" type="button"></button>
                <button class="search__submit" type="submit"></button>
                <div class="search__modal-wrapper">
                    <div class="search__modal">
                        <div class="search__modal-header">
                            <b>Настройка поиска</b>
                            Ищем в:
                        </div>
                        <div class="search__modal-body">
                            <input class="search__input-checkbox" id="search__input-article" type="checkbox" name="LrPartsSearch[search_in_article]" checked readonly disabled="disabled">
                            <label for="search__input-article">Номере запчасти (Артикуле)</label>
                            <?= Html::activeCheckbox($searchModel, $searchModel::SEARCH_IN_NAME, ['tag' => false, 'name' => $searchModel::SEARCH_IN_NAME, 'class' => 'search__input-checkbox', 'id' => 'search__input-name', 'label' => false,]); ?>
                            <label for="search__input-name">Наименовании запчасти</label>
                            <button class="search__modal-close" type="submit">OK</button>
                        </div>
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </header>

    <main class="page-body__main">
        <? if (!empty($this->params['breadcrumbs'])): ?>
            <section class="breadcrumbs">
                <?= Breadcrumbs::widget([
                    'options' => ['class' => false,],
                    'itemTemplate' => "<li>{link}</li>\n",
                    'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                    'encodeLabels' => false,
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => '/',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </section>
        <? endif; ?>
        <!-- page title -->
        <section class="page-title">
            <h1><?php echo Html::encode($this->title) ?></h1>
            <?= $searchSettings ?>
        </section>

        <?= \common\widgets\Alert::widget(['isBackend' => false, 'view' => $this,]) ?>
        <? Yii::$app->session->removeAllFlashes() ?>

        <?= $content ?>
    </main>

    <?= $this->render('_footer_lrparts') ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
