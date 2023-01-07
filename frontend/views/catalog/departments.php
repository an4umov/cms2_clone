<?php

/**
 * @var \yii\web\View $this
 * @var array $breadcrumbs
 * @var $trees array
 * @var $departments array
 * @var \common\models\GreenMenu $departmentMenu
 * @var $activeGeneration string
 */

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\models\Catalog;

$this->params[AppHelper::GREEN_MENU_ACTIVE] = AppHelper::GREEN_MENU_DEPARTMENTS;

$last = end($breadcrumbs);
if (!empty($last['label'])) {
    $this->title = $last['label'];
} else {
    $this->title = $departmentMenu->title;
}
?>
<? if (count($breadcrumbs) > 0): ?>
    <?= \frontend\components\widgets\BreadcrumbsWidget::widget(['breadcrumbs' => $breadcrumbs,]); ?>
<? endif; ?>
<?//= \frontend\components\widgets\NewItemGroupsWidget::widget(['model' => $departmentMenu->landingPage,]) ?>

<!-- Catalog Model Auto -->
<section class="model-auto" style="margin-top: 10px">
    <!-- Generations -->
    <? foreach ($trees as $typeCode => $tree): ?>
        <div class="model-auto__generation" style="display: block;">
            <div class="model-auto__generation-title">Выберите департамент</div>
            <ul class="model-auto__generation-list">
                <? foreach ($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $generationCode => $generation): ?>
                    <li class="model-auto__generation-item <?= !empty($generation['link_anchor']) ? 'model-auto__generation-item--link_anchor' : '' ?> <?= $activeGeneration === $generationCode ? 'model-auto__generation-item--active' : '' ?>">
                        <a href="<?= CatalogHelper::getGenerationUrl($departments, $generationCode, $generation) ?>" data-code="<?= $generationCode ?>" <?= !empty($generation['link_anchor']) ? 'target="_blank"' : '' ?>>
                            <div class="model-auto__generation-item-picture">
                                <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($generationCode) ?>" alt="<?= $generationCode ?>">
                            </div>
                            <div class="model-auto__generation-item-text"><?= $generation['name'] ?></div>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
    <? endforeach; ?>
</section>

<?= \frontend\components\widgets\ContentWidget::widget(['model' => $departmentMenu->landingPage, 'shop' => null, 'isPage' => true,]) ?>