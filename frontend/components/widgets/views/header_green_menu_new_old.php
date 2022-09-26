<?php
/**
 * @var string $shop
 * @var string $activeMenu
 * @var array  $departmentMenus
 * @var string $activeTag
 * @var array  $departmentMenuTags
 * @var \common\models\Content  $productsModel
 * @var \common\models\Content  $modelsModel
 * @var \common\models\GreenMenu[]  $greenMenuModels
 */
use \yii\helpers\Html;
use \common\components\helpers\BlockHelper;

?>
<nav class="navigation">
    <ul class="navigation__catalog-links">
        <li class="navigation__catalog-link--groups">
            <a href="catalog__departament.html">Группы товаров</a>
        </li>
        <li class="navigation__catalog-link--car">
            <a href="catalog__model-auto.html">Модели авто</a>
        </li>
    </ul>
    <div class="navigation__arrow-left"></div>
    <div class="navigation__arrow-right"></div>
    <ul class="navigation__nav-list">
        <li class="navigation__nav-item">
            <a href="">Скидка дня</a>
            <span style="background-color: #E93333;">777</span>
        </li>
        <li class="navigation__nav-item">
            <a href="">Новые поступления</a>
            <span style="background-color: #01B047;">42</span>
        </li>
        <li class="navigation__nav-item">
            <a href="news.html">Новости</a>
            <span>7</span>
        </li>
        <li class="navigation__nav-item">
            <a href="">Блог</a>
        </li>
        <li class="navigation__nav-item">
            <a href="">Галлерея</a>
        </li>
        <li class="navigation__nav-item">
            <a href="offers-catalog.html">Каталог товаров</a>
        </li>
        <li class="navigation__nav-item">
            <a href="offers-catalog.html">Extra item</a>
        </li>
    </ul>
</nav>






<section class="page-navigation" style="margin-top: 5px;">
    <div class="main-navigation--mobile">
        <div class='main-nav-dropdown' id='mainNavDropDown'>
            <div class='main-nav-dropdown-button' id='mainNavDropDownBtn'>Главное меню</div>
            <ul class='main-nav-dropdown-selection'>
            <?= Html::tag('li', BlockHelper::getGreenMenuNewLinkUrl($productsModel)) ?>
            <?= Html::tag('li', BlockHelper::getGreenMenuNewLinkUrl($modelsModel)) ?>

            <? foreach ($greenMenuModels as $model): ?>
                <?= Html::tag('li', BlockHelper::getGreenMenuNewGreenMenuLinkUrl($model)) ?>
            <? endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="main-navigation--desktop">
        <ul class='main-navigation--desktop__list'>
            <li<?= (!empty($activeMenu) && $activeMenu === $productsModel->alias) ? ' class="main-nav__item--active"' : ''?>>
                <?= BlockHelper::getGreenMenuNewLinkUrl($productsModel) ?>
            </li>
            <li<?= (!empty($activeMenu) && $activeMenu === $modelsModel->alias) ? ' class="main-nav__item--active"' : ''?>>
                <?= BlockHelper::getGreenMenuNewLinkUrl($modelsModel) ?>
            </li>

            <? foreach ($greenMenuModels as $model): ?>
                <li<?= (!empty($activeMenu) && $activeMenu === $model->landingPage->alias) ? ' class="main-nav__item--active"' : ''?>>
                    <?= BlockHelper::getGreenMenuNewGreenMenuLinkUrl($model) ?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</section>
