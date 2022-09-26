<?php

use frontend\models\search\LrPartsSearch;
use yii\data\Pagination;

/* @var \yii\web\View $this
 * @var \frontend\models\search\SiteSearch $searchModel
 * @var array $params
 * @var array $errors
 * @var array $rubrics
 * @var array $items
 * @var Pagination $pagination
*/

$this->title = 'Результат поиска';
$this->params['searchModel'] = $searchModel;
$this->params['searchSettings'] = '<div class="page-title__search-settings">(поиск проведен по Номеру детали и Наименованию. <a href="#" class="searchModalToggle">Изменить настройки)</a></div>';

$this->params['breadcrumbs'][] = ['label' => \frontend\controllers\LrPartsController::BREADCRUMB_NAME, 'url' => ['/',],];
$this->params['breadcrumbs'][] = ['label' => 'Результаты поиска по запросу "'.$params[LrPartsSearch::TEXT].'"', 'url' => \yii\helpers\Url::to(['lr-parts/search', \frontend\models\search\LrPartsSearch::TEXT => $params[LrPartsSearch::TEXT],]),];

if (!empty($errors)) {
    foreach ($errors as $error) {
        $text = array_shift($error);
        echo \yii\helpers\Html::tag('p', \yii\helpers\Html::tag('strong', 'Ошибка: ').$text, ['class' => 'text-error',]).PHP_EOL;
    }
} ?>

<? if (empty($errors)): ?>
    <!-- catalog search -->
    <section class="catalog-search">
        <ol class="catalog-search__results-list">
            <? foreach ($items as $code => $item): ?>
            <li class="catalog-search__results-list-item">
                <span class="catalog-search__results-title"><b><?= $code ?></b> <?= !empty($item['article_name']) ? $item['article_name'] : $item['name'] ?></span>
                <? if (isset($rubrics[$code])): ?>
                <ul class="catalog-search__results-cats-list">
                    <li class="catalog-search__results-cats-list--title">В категориях:</li>
                    <? foreach ($rubrics[$code] as $labels): ?>
                        <li class="catalog-search__results-cats-list--item"><?= $labels ?></li>
                    <? endforeach; ?>
                </ul>
                <? endif; ?>
            </li>
            <? endforeach; ?>
        </ol>
        <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
                'firstPageCssClass' => 'btn first',
                'firstPageLabel' => 'Первая',
                'lastPageCssClass' => 'btn last',
                'lastPageLabel' => 'Последняя',
                'hideOnSinglePage' => true,
                'maxButtonCount' => 10,
                'nextPageCssClass' => 'btn next',
                'nextPageLabel' => '❯',
                'prevPageCssClass' => 'btn prev',
                'prevPageLabel' => '❮',
        ]) ?>
    </section>
<? endif; ?>
