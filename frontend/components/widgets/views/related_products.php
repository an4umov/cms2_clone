<?php

use common\components\helpers\CatalogHelper;
use \yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var array $models
 */
?>
<!-- Related-products -->
<section class="related-products">
    <h2 class="related-products__title">СОВЕТУЕМ ПОСМОТРЕТЬ: СВЯЗАННЫЕ ТОВАРЫ</h2>
    <div class="related-products__container related-product">
        <? foreach ($models as $model): ?>
            <? foreach ($model['articles'] as $article): ?>
            <article class="related-product__card">
                <?
                $image = CatalogHelper::getSpecialOfferImageUrl($article['number']);
                echo '<div class="related-product__stock" style="background-color: '.$model['color'].';">'.$model['recomendation'].'</div>';

                if (!empty($image)) {
                    echo Html::a(Html::img($image), ['article/view', 'number' => $article['number'],], ['class' => 'related-product__card-photo', 'width' => 180,]);
                }
                ?>
                <div class="related-product__card-departament">
                    <p><?= $article['number'] ?></p>
                </div>
                <div class="related-product__card-descr">
                    <p><?= $article['name'] ?></p>
                </div>
                <div class="related-product__card-bottom">
                    <? if (is_numeric($article['price'])): ?>
                    <div class="related-product__card-price">
                        <span>Цена от:</span>
                        <div class="related-rub"><?= CatalogHelper::formatPrice($article['price']) ?></div>
                    </div>
                    <? endif; ?>
                    <a href="" class="related-fav-btn"></a>
                    <? if (is_numeric($article['price'])): ?>
                        <a href="" class="related-buy-btn"></a>
                    <? endif; ?>
                </div>
            </article>
            <? endforeach; ?>
        <? endforeach; ?>
    </div>
</section>
