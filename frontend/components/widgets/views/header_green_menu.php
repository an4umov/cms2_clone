<?php
/**
 * @var string $shop
 * @var string $activeMenu
 * @var array  $departmentMenus
 * @var string $activeTag
 * @var array  $departmentMenuTags
 * @var array  $allContentFilterPages
 */
use \yii\helpers\Html;
use \common\components\helpers\BlockHelper;

?>
<section class="page-navigation">
<? if ($departmentMenus): ?>
    <div class="main-navigation--mobile">
        <div class='main-nav-dropdown' id='mainNavDropDown'>
            <div class='main-nav-dropdown-button' id='mainNavDropDownBtn'>Главное меню</div>
            <ul class='main-nav-dropdown-selection'>
            <? foreach ($departmentMenus as $url => $menuItem): ?>
                <?= Html::tag('li', BlockHelper::getGreenMenuLinkUrl($shop, $menuItem)) ?>
            <? endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="main-navigation--desktop">
        <ul class='main-navigation--desktop__list'>
            <? foreach ($departmentMenus as $url => $menuItem): ?>
                <li<?= (!empty($activeMenu) && $activeMenu === $url) ? ' class="main-nav__item--active"' : ''?>>
                    <?= BlockHelper::getGreenMenuLinkUrl($shop, $menuItem) ?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>

<? if ($departmentMenuTags): ?>
    <div class="tags-navigation--mobile">
        <div class='tags-nav-dropdown' id='tagsNavDropDown'>
            <div class='tags-nav-dropdown-button' id='tagsNavDropDownBtn'>Выберите раздел</div>
            <ul class='tags-nav-dropdown-selection'>
                <? foreach ($departmentMenuTags as $tagItem): ?>
                    <?= Html::tag('li', BlockHelper::getGreenMenuTagLinkUrl($shop, $activeMenu, $tagItem)) ?>
                <? endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="tags-navigation--desktop">
        <ul class="tags-navigation--desktop__list">
            <? foreach ($departmentMenuTags as $tagItem): ?>
                <li<?= ($activeTag === $tagItem['url']) ? ' class="tags-nav__item--active"' : ''?>>
                    <?= BlockHelper::getGreenMenuTagLinkUrl($shop, $activeMenu, $tagItem) ?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>
</section>
