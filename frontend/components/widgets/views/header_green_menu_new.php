<?php
/**
 * @var string $activeMenu
 * @var \common\models\GreenMenu $departmentMenu
 * @var \common\models\GreenMenu[] $greenMenus
 * @var string $lastModelsUrl
 * @var string $lastGroupsUrl
 */
use \yii\helpers\Url;
use \common\components\helpers\AppHelper;

?>
<nav class="navigation">
    <ul class="navigation__catalog-links">
        <? if ($departmentMenu): ?>
        <li class="navigation__catalog-link--groups<?= $activeMenu === AppHelper::GREEN_MENU_DEPARTMENTS ? '-active' : '' ?>">
            <a href="<?= !empty($lastGroupsUrl) ? $lastGroupsUrl : '/departments' ?>"><?= $departmentMenu->title ?></a>
        </li>
        <? endif; ?>
        <li class="navigation__catalog-link--car<?= $activeMenu === AppHelper::GREEN_MENU_MODELS ? '-active' : '' ?>">
            <a href="<?= !empty($lastModelsUrl) ? $lastModelsUrl : '/models' ?>">Модели авто</a>
        </li>
    </ul>
    <div class="navigation__arrow-left"></div>
    <div class="navigation__arrow-right"></div>
    <? if ($greenMenus): ?>
    <ul class="navigation__nav-list">
        <? foreach ($greenMenus as $greenMenu): ?>
            <li class="navigation__nav-item">
                <a href="<?= $greenMenu->landingPage->getContentUrl() ?>"><?= $greenMenu->title ?></a>
            </li>
        <? endforeach; ?>
    </ul>
    <? endif; ?>
</nav>
