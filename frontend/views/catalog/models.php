<?php

/**
 * @var $this \yii\web\View
 * @var $breadcrumbs array
 * @var $departments array
 * @var $types array
 * @var $trees array
 * @var $activeType string
 * @var $activeBrand string
 * @var $activeModel string
 * @var $activeGeneration string
 * @var $group string
 * @var $groupTitle string
 */

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\models\Catalog;
use yii\helpers\Url;

$this->params[AppHelper::GREEN_MENU_ACTIVE] = AppHelper::GREEN_MENU_MODELS;

$last = end($breadcrumbs);
if (!empty($last['label'])) {
    $this->title = $last['label'];
} else {
    $this->title = 'Модели авто';
}
?>
<? if (count($breadcrumbs) > 0): ?>
    <?= \frontend\components\widgets\BreadcrumbsWidget::widget(['breadcrumbs' => $breadcrumbs,]); ?>
<? endif; ?>

<? if ($groupTitle): ?>
    <div class="shop-catalog__products-by-group">Товары по группе: <span><?= $groupTitle ?></span>  <a href="/models"></a></div>
<? endif; ?>

<!-- Catalog Model Auto -->
<section class="model-auto" style="margin-top: 10px">
    <!-- Model auto BRAND -->
    <div class="model-auto__brand">
        <div class="model-auto__brand-title">Выберите марку</div>
        <div class="model-auto__brand-tabbed">
            <? $index = 1; ?>
            <? foreach ($types as $type): ?>
            <input type="radio" name="tabs" id="model-tab-type-<?= $index ?>" <?= $activeType === $type->code ? 'checked' : ''?>>
            <label for="model-tab-type-<?= $index++ ?>">
                <?= $trees[$type->code][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['name'] ?>
                <?= CatalogHelper::renderTagForLinkCounter($groupTitle, $trees[$type->code][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT], CatalogHelper::COUNTER_TYPE_TYPE); ?>
            </label>
            <? endforeach; ?>

            <div class="model-auto__brand-tabcontent">
                <? /** @var Catalog $type */ ?>
                <? foreach ($types as $type): ?>
                <ul class="model-auto__brand-list <?= $type->tabClass ?>">
                    <? foreach ($trees[$type->code][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $firstChildrenCode => $firstChildren): ?>
                        <li class="model-auto__brand-item <?= $activeBrand === $firstChildrenCode ? 'model-auto__brand-item--active' : '' ?>" data-code="<?= $firstChildrenCode ?>">
                            <?= $firstChildren['name'] ?>
                            <?= CatalogHelper::renderTagForLinkCounter($groupTitle, $firstChildren, CatalogHelper::COUNTER_TYPE_MODEL); ?>
                        </li>
                    <? endforeach; ?>
                </ul>
                <? endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Model auto MODEL -->
    <? foreach ($trees as $typeCode => $tree): ?>
        <? foreach ($tree[Catalog::TREE_LEVEL_SECOND] as $brandCode => $modelData): ?>
            <div class="model-auto__model" data-code="<?= $brandCode ?>">
                <div class="model-auto__model-title">Выберите модель</div>
                <ul class="model-auto__model-list">
                <? /** @var $model array */?>
                <? foreach ($modelData[Catalog::TREE_ITEM_CHILDREN] as $modelCode => $model): ?>
                    <li class="model-auto__model-item <?= $activeModel === $modelCode ? 'model-auto__model-item--active' : '' ?>" data-code="<?= $modelCode ?>">
                        <?= $model['name'] ?>
                        <?= CatalogHelper::renderTagForLinkCounter($groupTitle, $model, CatalogHelper::COUNTER_TYPE_MODEL); ?>
                    </li>
                <? endforeach; ?>
                </ul>
            </div>
        <? endforeach; ?>
    <? endforeach; ?>

    <!-- Generations -->
    <? foreach ($trees as $typeCode => $tree): ?>
        <? foreach ($tree[Catalog::TREE_LEVEL_THIRD] as $modelCode => $generationData): ?>
            <div class="model-auto__generation" data-code="<?= $modelCode ?>" >
                <div class="model-auto__generation-title">Выберите поколение</div>
                <ul class="model-auto__generation-list">
                <? foreach ($generationData[Catalog::TREE_ITEM_CHILDREN] as $generationCode => $generation): ?>
                    <li class="model-auto__generation-item <?= !empty($generation['link_anchor']) ? 'model-auto__generation-item--link_anchor' : '' ?> <?= $activeGeneration === $generationCode ? 'model-auto__generation-item--active' : '' ?>">
                        <a href="<?= CatalogHelper::getGenerationUrl($departments, $generationCode, $generation, $group) ?>" data-code="<?= $generationCode ?>" <?= !empty($generation['link_anchor']) ? 'target="_blank"' : '' ?>>
                            <div class="model-auto__generation-item-picture">
                                <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($generationCode) ?>" alt="<?= $generationCode ?>">
                            </div>
                            <div class="model-auto__generation-item-text">
                                <?= $generation['name'] ?>
                                <?= CatalogHelper::renderTagForLinkCounter($groupTitle, $generation, CatalogHelper::COUNTER_TYPE_GENERATION); ?>
                            </div>
                        </a>
                    </li>
                <? endforeach; ?>
                </ul>
            </div>
        <? endforeach; ?>
    <? endforeach; ?>

    <?= \frontend\components\widgets\WatchedEarlierWidget::widget(['groupTitle' => $groupTitle, 'group' => $group, 'trees' => $trees,]); ?>

</section>

