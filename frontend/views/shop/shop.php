<?php

/**
 * @var \yii\web\View             $this
 * @var string                    $id
 * @var string                    $shop
 * @var int                       $carModelID
 * @var \common\models\Department $department
 * @var array                     $activeCarModel
 * @var string                    $activeDepartmentMenu
 * @var string                    $activeDepartmentMenuTag
 * @var string                    $catalogCode
 * @var array                     $pageData
 * @var array                     $tree
 * @var array                     $breadcrumbs
 * @var bool                      $isGroupDepartment
 * @var string                    $group
 */

use \common\components\helpers\AppHelper;
use \common\components\helpers\CatalogHelper;
use \common\components\helpers\ContentHelper;
use \frontend\components\widgets\ContentWidget;
use \frontend\components\widgets\ShopContentWidget;
use yii\helpers\Url;

$this->title = $pageData['title'] ?? '';

$this->params[AppHelper::TEMPLATE_KEY_SHOP] = $shop;
$this->params[AppHelper::TEMPLATE_KEY_SHOP_MENU] = $activeDepartmentMenu;
$this->params[AppHelper::TEMPLATE_KEY_SHOP_MENU_TAG] = $activeDepartmentMenuTag;

$this->params[AppHelper::GREEN_MENU_ACTIVE] = $isGroupDepartment ? AppHelper::GREEN_MENU_DEPARTMENTS : AppHelper::GREEN_MENU_MODELS;

$content = ShopContentWidget::widget([
    'department' => $department, // Department
    'carModelID' => $carModelID, // int
    'departmentMenu' => $activeDepartmentMenu, // string
    'departmentMenuTag' => $activeDepartmentMenuTag, // string
    'catalogCode' => $catalogCode, // string
    'pjaxId' => $id,
    'group' => $group,
]);

$pageTitle = '';

$dom = new DOMDocument;
@$dom->loadHTML('<?xml encoding="utf-8" ?>'.$content);
$pageTitleElement = $dom->getElementById(ShopContentWidget::PAGE_TITLE_HIDDEN_ID);
if ($pageTitleElement) {
    $pageTitle = $pageTitleElement->textContent;
}
if ($pageTitle) {
    $this->title = $pageTitle;
}

$imageSrc = '';
if (!empty($department->image)) {
    $imageSrc = ContentHelper::prepareImage($department->image);
} elseif (!empty($department->catalog_code)) {
    $imageSrc = CatalogHelper::getCatalogTopLevelImageUrl($department->catalog_code);
}

echo \frontend\components\widgets\BreadcrumbsWidget::widget(['breadcrumbs' => $breadcrumbs,]);
?>

<!-- Catalog departament -->
<section class="catalog__departament">
    <? if ($imageSrc): ?>
    <!-- Catalog dep PICTURE -->
    <div class="catalog__departament-picture">
        <img src="<?= $imageSrc ?>" alt="<?= $department->name ?>">
    </div>
    <? endif; ?>
    <div class="catalog__departament-wrapper">
        <!-- Catalog dep TITLE -->
        <div class="catalog__departament-title"><?= $department->name ?></div>

        <? if ($tree): ?>
        <!-- Catalog dep NAVIGATION -->
        <ul class="catalog__departament-navigation-list">
            <? foreach ($tree as $menuID => $menuData): ?>
                <? if ($menuData['children']): ?>
                    <li class="catalog__departament-navigation-item catalogDepOpenSubnav"><?= $menuData['name'] ?>
                        <ul class="catalog__departament-subnavigation-list">
                            <? foreach ($menuData['children'] as $menuTagID => $menuTagData): ?>
                            <li class="catalog__departament-subnavigation-item<?= !empty($activeDepartmentMenuTag) && $activeDepartmentMenuTag === $menuTagData['url'] ? ' catalog__departament-subnavigation-item__active' : '' ?>" data-url="<?= $menuTagData['url'] ?>"><a class="catalog__departament-navigation-item-link" href="<?= Url::to(['shop/shop', 'shop' => $department->url, 'menu' => $menuData['url'], 'tag' => $menuTagData['url'],]) ?>"><?= $menuTagData['name'] ?></a></li>
                            <? endforeach; ?>
                        </ul>
                    </li>
                <? else: ?>
                    <li class="catalog__departament-navigation-item<?= !empty($activeDepartmentMenu) && $activeDepartmentMenu === $menuData['url'] ? ' catalog__departament-navigation-item__active' : '' ?>" data-url="<?= $menuData['url'] ?>"><a class="catalog__departament-navigation-item-link" href="<?= Url::to(['shop/shop', 'shop' => $department->url, 'menu' => $menuData['url'],]) ?>"><?= $menuData['name'] ?></a></li>
                <? endif; ?>
            <? endforeach; ?>
        </ul>
        <? endif; ?>
    </div>
</section>
<?php 
    if ($newsAlias) {
        echo ContentWidget::widget(['model' => $model, 'shop' => $shop, 'isPage' => true,]);
    } else {
        echo $content;
    }
?>