<?php
/**
 * @var $this yii\web\View
 * @var \common\models\Content[] $models
 * @var string $header
 * @var int $anonsCount
 * @var bool $isExpand
 */

use \common\components\helpers\ContentHelper;

?>
<section class="news-container">
    <div class="news-container__title">
        <h2><?= $header ?: 'Последние новости' ?></h2>
        <? if (!empty($isExternal) && count($models)): ?>
            <a class="watch-all-btn" href="<?=$isExternal ?>">Смотреть все</a>
        <? endif; ?>
    </div>
    <div class="news-slider js-news-slider">
        <div class="news-slider__items js-news-slider__items">
            <? foreach ($models as $model): ?>
                <?= ContentHelper::renderLastNews($model) ?>
            <? endforeach; ?>
        </div>
        <? if (count($models)): ?>
        <div class="news-slider__control news-slider__control--previous js-news-slider__previous"></div>
        <div class="news-slider__control news-slider__control--next js-news-slider__next"></div>
        <? endif; ?>
    </div>
</section>