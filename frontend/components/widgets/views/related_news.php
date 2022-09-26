<?php

use common\components\helpers\CatalogHelper;
use common\models\SpecialOffers;
use \yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var array $models
 * @var array $articles
 */
?>
<!--pre><? //print_r($articles)?></pre-->
<!-- Related news-->
<section class="related-news">
    <h2 class="related-news__title">ЧИТАЙТЕ СТАТЬИ ПО ДАННОМУ ТОВАРУ</h2>
    <div class="related-news__inner">
    <? foreach ($models as $model): ?>
        <?= \common\components\helpers\ContentHelper::renderRelatedContent($model) ?>
    <? endforeach; ?>
    </div>
</section>
