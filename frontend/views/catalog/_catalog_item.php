<?php

/* @var \common\models\Catalog $model
/* @var \common\models\CatalogTreeSetting $setting
/* @var string $selectedCode
 * @var \yii\web\View $this
 * @var int $index
 */
$index += 1;
?>
<div class="<?= $setting->getRowCountClass() ?>">
    <div class="catalog1<?= !empty($selectedCode) ? ($selectedCode === $model->code ? ' active' : '') : '' ?>" data-code="<?= $model->code ?>" data-level="<?= $model->level ?>" style="height: <?= $setting->grid_height ?>px;">
        <div class="img_cat"><img class="img-fluid" src="<?= \common\components\helpers\CatalogHelper::getCatalogTopLevelImageUrl($model->code) ?>" alt="<?//= $model->title ?>"></div>
        <div class="title_cat"><?= $model->name ?></div>
    </div>
</div>