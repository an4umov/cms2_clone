<?php

use common\components\helpers\CatalogHelper;
use common\models\SpecialOffers;
use \yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var array $models
 */
?>
<!-- Categories -->
<section class="categories">
    <h2 class="categories__title">ВАС МОГУТ ЗАИНТЕРЕСОВАТЬ ДРУГИЕ РАЗДЕЛЫ ИНТЕРНЕТ МАГАЗИНА</h2>
    <ul class="categories__list categories-list">
        <? foreach ($models as $model): ?>
        <li class="categories-list__item categories-list-item">
            <a href="/catalog/code/<?= $model['code'] ?>">
                <div class="categories-list-item__title">
                    <?= $model['name'] ?>
                </div>
                <div class="categories-list-item__picture">
                    <?= Html::img($model['image'], ['alt' => '',]) ?>
                </div>
                <div class="categories-list-item__quantity">
                    <?= Yii::$app->i18n->format('{n, plural, =0{# Товаров} =1{# Товар} one{# Товаров} few{# Товаров} many{# Товаров} other{# Товаров}}',
                         ['n' => $model['count'],],
                'ru_RU'
                    );?>
                </div>
            </a>
        </li>
        <? endforeach; ?>
    </ul>
</section>
