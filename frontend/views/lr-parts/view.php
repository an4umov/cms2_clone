<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\ParserLrpartsRubrics $model
 * @var \common\models\ParserLrpartsRubrics[] $children
 * @var \common\models\ParserLrpartsItems[] $items
 * @var array $breadcrumbs
 */

$this->title = $model->name;
$this->params['breadcrumbs'] = $breadcrumbs;
?>

<? if (!empty($children)): ?>
    <?
    $isLast = true;
    foreach ($children as $child) {
        if (!$child->is_last) {
            $isLast = false;
            break;
        }
    }
    ?>
    <? if ($isLast): ?>
        <section class="catalog-parts">
        <? foreach ($children as $child): ?>
            <div class="catalog-parts__item">
                <a href="<?= \yii\helpers\Url::to(['lr-parts/view', 'id' => $child->id,]) ?>" class="catalog-parts__item-link">
                    <h2 class="catalog-parts__item-name"><?= $child->name ?></h2>
                    <?= \yii\helpers\Html::img($child->getImageSrc(), ['alt' => '', 'class' => 'catalog-parts__item-img',]) ?>
                </a>
            </div>
        <? endforeach; ?>
        </section>
    <? else: ?>
        <section class="catalog-cat">
        <? foreach ($children as $child): ?>
            <div class="catalog-cat__item">
                <a href="<?= \yii\helpers\Url::to(['lr-parts/view', 'id' => $child->id,]) ?>" class="catalog-cat__item-link">
                    <div class="catalog-cat__item-icon-wrapper">
                        <?= \yii\helpers\Html::img($child->getImageSrc(), ['alt' => '', 'class' => 'catalog-cat__item-icon',]) ?>
                    </div>
                    <div class="catalog-cat__item-text"><?= $child->name ?></div>
                </a>
            </div>
        <? endforeach; ?>
        </section>
    <? endif; ?>
<? else: ?>
    <!-- catalog part page -->
    <section class="catalog-detail">
        <div class="catalog-detail__inner">
            <? if (!empty($model->description) && !empty($model->description_bottom)): ?>
            <!-- catalog text banner -->
            <div class="catalog-detail__text-banner">
                <?= $model->description ?>
            </div>
            <? endif; ?>
            <div class="catalog-detail__left">
                <div class="catalog-detail__img-wrapper">
                    <?= \yii\helpers\Html::img($model->getImageSrc(), ['alt' => '', 'class' => 'catalog-detail__img',]) ?>
                </div>
            </div>
            <div class="catalog-detail__right">
                <? if ($items): ?>
                <!-- catalog desktop table -->
                <div class="part-table-desktop">
                    <div class="part-table-desktop__row">
                        <div class="part-table-desktop__col--title">На схеме</div>
                        <div class="part-table-desktop__col--title">Part Number</div>
                        <div class="part-table-desktop__col--title">Наименование</div>
<!--                        <div class="part-table-desktop__col--title">Наличие</div>-->
<!--                        <div class="part-table-desktop__col--title">Цена от</div>-->
                    </div>
                    <? foreach ($items as $item): ?>
<!--                    <a href="--><?//= \yii\helpers\Url::to(['lr-parts/search', \frontend\models\search\LrPartsSearch::TEXT => $item->code,]) ?><!--" class="part-table-desktop__row" target="_blank" title="Посмотреть в интернет-магазине">-->
                    <a href="https://lr.ru/search/type/catalog/query/<?= $item->code ?>" class="part-table-desktop__row" target="_blank" title="Посмотреть в интернет-магазине">
                        <div class="part-table-desktop__col"><span><?= $item->position ?></span></div>
                        <div class="part-table-desktop__col"><?= $item->code ?></div>
                        <div class="part-table-desktop__col"><?= $item->getItemName() ?></div>
<!--                        <div class="part-table-desktop__col">Склад Москва</div>-->
<!--                        <div class="part-table-desktop__col">Запрос</div>-->
                    </a>
                    <? endforeach; ?>
                </div>

                <!-- catalog mobile table -->
                <div class="part-table-mobile">
                    <? foreach ($items as $item): ?>
<!--                    <a href="--><?//= \yii\helpers\Url::to(['lr-parts/search', \frontend\models\search\LrPartsSearch::TEXT => $item->code,]) ?><!--" class="part-table-mobile__inner" target="_blank" title="Посмотреть в интернет-магазине">-->
                    <a href="https://lr.ru/search/type/catalog/query/<?= $item->code ?>" class="part-table-mobile__inner" target="_blank" title="Посмотреть в интернет-магазине">
                        <div class="part-table-mobile__row--first">
                            <div class="part-table-mobile__col--main-title">Наименование</div>
                            <div class="part-table-mobile__col"><?= $item->name ?></div>
                        </div>
                        <div class="part-table-mobile__row">
                            <div class="part-table-mobile__col--title">На схеме</div>
                            <div class="part-table-mobile__col--title">Part Number</div>
                        </div>
                        <div class="part-table-mobile__row">
                            <div class="part-table-mobile__col"> <span><?= $item->position ?></span></div>
                            <div class="part-table-mobile__col"><?= $item->code ?></div>
                        </div>
<!--                        <div class="part-table-mobile__row">-->
<!--                            <div class="part-table-mobile__col--title">Наличие</div>-->
<!--                            <div class="part-table-mobile__col--title">Цена от</div>-->
<!--                        </div>-->
<!--                        <div class="part-table-mobile__row">-->
<!--                            <div class="part-table-mobile__col">Склад Москва</div>-->
<!--                            <div class="part-table-mobile__col">Запрос</div>-->
<!--                        </div>-->
                    </a>
                    <? endforeach; ?>
                </div>
                <? endif; ?>
            </div>
            <? if (!empty($model->description) && !empty($model->description_bottom)): ?>
            <!-- catalog text banner -->
            <div class="catalog-detail__text-banner">
                <?= $model->description_bottom ?>
            </div>
            <? endif; ?>
        </div>
    </section>
<? endif; ?>
