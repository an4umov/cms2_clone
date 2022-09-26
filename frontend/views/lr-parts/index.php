<?php

/**
 * @var \yii\web\View $this
 * @var string $title
 * @var ParserLrpartsRubrics[] $models
 */

use common\models\ParserLrpartsRubrics;

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/',],];
?>
<!-- catalog grid -->
<section class="catalog-grid">
    <? foreach ($models as $model): ?>
    <div class="catalog-grid__item">
        <a href="<?= \yii\helpers\Url::to(['lr-parts/view', 'id' => $model->id,]) ?>" class="catalog-grid__item-link">
            <h2 class="catalog-grid__item-name"><?= $model->name ?></h2>
            <?= \yii\helpers\Html::img($model->getImageSrc(), ['alt' => '', 'class' => 'catalog-grid__item-img',]) ?>
        </a>
    </div>
    <? endforeach; ?>
</section>
