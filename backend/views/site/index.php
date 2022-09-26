<?php

use\common\models\ContentBlock;
use backend\components\helpers\IconHelper;
use common\models\Block;
use common\models\FormSended;
use common\models\QuestionSended;
use \miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use \common\models\Content;

/* @var $this yii\web\View */
/* @var $countStructureDepartment int */
/* @var $countStructureMenu int */
/* @var $countStructureModel int */
/* @var $countStructureTag int */
/* @var $data array */
/* @var $sendedData array */
/* @var $contentBlockTypeCounts array */
/* @var $globalTypeCounts array */
/* @var $contentTypeCounts array */

$this->title = 'Главная';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_HOME_PAGE);

HighchartsAsset::register($this)->withScripts(['highcharts-3d',]);
?>
<div class="container" style="width: 100%; padding-left: 10px; padding-right: 10px; padding-top: 10px;">
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Контент</div>
                <div class="panel-body">
                    <?
                    $model = new Content();
                    $chartData = [];
                    foreach ($contentTypeCounts as $type => $count) {
                        $chartData[] = ['name' => $model->getTypeTitle($type), 'y' => (int)$count,];
                    }

                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'options3d' => [
                                    'enabled' => (bool) true,
                                    'alpha' => 45,
                                ],
                            ],
                            'title' => ['text' => 'Общее количество актуального контента',],
                            'subtitle' => [
                                'text' => 'За все время существования проекта',
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'innerSize' => 100,
                                    'depth' => 45,
                                ],
                                'series' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '{point.name}: {point.y}'
                                    ],
                                ],
                            ],
                            'series' => [
                                [
                                    'name' => 'Количество',
                                    'data' => $chartData,
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Глобальные блоки</div>
                <div class="panel-body">
                    <?
                    $model = new Block();
                    $chartData = [];
                    foreach ($globalTypeCounts as $type => $count) {
                        $chartData[] = ['name' => $model->getGlobalTypeTitle($type), 'y' => (int)$count,];
                    }

                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'options3d' => [
                                    'enabled' => (bool) true,
                                    'alpha' => 45,
                                ],
                            ],
                            'title' => ['text' => 'Типы контента',],
                            'subtitle' => [
                                'text' => 'За все время существования проекта',
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'innerSize' => 100,
                                    'depth' => 45,
                                ],
                                'series' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '{point.name}: {point.y}'
                                    ],
                                ],
                            ],
                            'series' => [
                                [
                                    'name' => 'Количество',
                                    'data' => $chartData,
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Типы блоков</div>
                <div class="panel-body">
                    <?
                    $model = new ContentBlock();
                    $chartData = [];
                    $chartColors = [$model::TYPE_BLOCK => '#8DC3FF', $model::TYPE_BLOCK_READY => '#84A1FF', $model::TYPE_FORM => '#FF6246',];
                    foreach ($contentBlockTypeCounts as $contentBlockType => $contentBlockCount) {
                        $chartData[] = ['name' => $model->getTypeTitle($contentBlockType), 'y' => (int)$contentBlockCount, 'color' => $chartColors[$contentBlockType],];
                    }

                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'options3d' => [
                                    'enabled' => (bool) true,
                                    'alpha' => 45,
                                ],
                            ],
                            'title' => ['text' => 'Типы блоков',],
                            'subtitle' => [
                                'text' => 'За все время существования проекта',
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'innerSize' => 100,
                                    'depth' => 45,
                                ],
                                'series' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '{point.name}: {point.y}'
                                    ],
                                ],
                            ],
                            'series' => [
                                [
                                    'name' => 'Количество',
                                    'data' => $chartData,
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Структура</div>
                <div class="panel-body">
                    <?
                    $model = new Block();
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'options3d' => [
                                    'enabled' => (bool) true,
                                    'alpha' => 45,
                                ],
                            ],
                            'title' => ['text' => 'Структуры проекта',],
                            'subtitle' => [
                                'text' => 'За все время существования',
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'innerSize' => 100,
                                    'depth' => 45,
                                ],
                                'series' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '{point.name}: {point.y}'
                                    ],
                                ],
                            ],
                            'series' => [
                                [
                                    'name' => 'Количество',
                                    'data' => [
                                        ['name' => 'Департаменты', 'y' => (int)$countStructureDepartment, 'color' => '#8DC3FF',],
                                        ['name' => 'Меню', 'y' => (int)$countStructureMenu, 'color' => '#FF6246',],
                                        ['name' => 'Теги', 'y' => (int)$countStructureTag, 'color' => 'black',],
                                        ['name' => 'Модели', 'y' => (int)$countStructureModel, 'color' => '#84A1FF',],
                                    ],
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-danger">
                <div class="panel-heading">Формы</div>
                <div class="panel-body">
                    <?
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'line',
                            ],
                            'title' => ['text' => 'Отправленные формы',],
                            'subtitle' => [
                                'text' => 'Данные по дням за последний месяц',
                            ],
                            'xAxis' => [
                                'categories' => array_keys($sendedData[FormSended::tableName()]),
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => 'Количество',]
                            ],
                            'plotOptions' => [
                                'line' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                    ],
                                    'enableMouseTracking' => true,
                                ],
                            ],
                            'series' => [
                                ['name' => 'Формы', 'data' => array_values($sendedData[FormSended::tableName()]), 'color' => 'darkred',],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">Вопросы</div>
                <div class="panel-body">
                    <?
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'line',
                            ],
                            'title' => ['text' => 'Отправленные вопросы',],
                            'subtitle' => [
                                'text' => 'Данные по дням за последний месяц',
                            ],
                            'xAxis' => [
                                'categories' => array_keys($sendedData[QuestionSended::tableName()]),
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => 'Количество',]
                            ],
                            'plotOptions' => [
                                'line' => [
                                    'dataLabels' => [
                                        'enabled' => true,
                                    ],
                                    'enableMouseTracking' => true,
                                ],
                            ],
                            'series' => [
                                ['name' => 'Вопросы', 'data' => array_values($sendedData[QuestionSended::tableName()]), 'color' => 'darkgreen',],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">Новости</div>
                <div class="panel-body">
                    <?
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                            ],
                            'title' => ['text' => 'Новости',],
                            'subtitle' => [
                                'text' => 'Данные по месяцам за последние 12 месяцев',
                            ],
                            'xAxis' => [
                                'categories' => array_keys($data[Content::TYPE_NEWS]),
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => 'Количество',]
                            ],
                            'plotOptions' => [
                                'column' => [
                                    'pointPadding' => 0.2,
                                    'borderWidth' => 0,
                                    'dataLabels' => [
                                        'enabled' => true,
                                    ],
                                ],
                            ],
                            'series' => [
                                ['name' => 'Новости', 'data' => array_values($data[Content::TYPE_NEWS]), 'color' => 'brown',],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">Статьи</div>
                <div class="panel-body">
                    <?
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                            ],
                            'title' => ['text' => 'Статьи',],
                            'subtitle' => [
                                'text' => 'Данные по месяцам за последние 12 месяцев',
                            ],
                            'xAxis' => [
                                'categories' => array_keys($data[Content::TYPE_ARTICLE]),
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => 'Количество',]
                            ],
                            'plotOptions' => [
                                'column' => [
                                    'pointPadding' => 0.2,
                                    'borderWidth' => 0,
                                    'dataLabels' => [
                                        'enabled' => true,
                                    ],
                                ],
                            ],
                            'series' => [
                                ['name' => 'Статьи', 'data' => array_values($data[Content::TYPE_ARTICLE]), 'color' => 'orange',],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">Страницы</div>
                <div class="panel-body">
                    <?
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                            ],
                            'title' => ['text' => 'Страницы',],
                            'subtitle' => [
                                'text' => 'Данные по месяцам за последние 12 месяцев',
                            ],
                            'xAxis' => [
                                'categories' => array_keys($data[Content::TYPE_PAGE]),
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => 'Количество',]
                            ],
                            'plotOptions' => [
                                'column' => [
                                    'pointPadding' => 0.2,
                                    'borderWidth' => 0,
                                    'dataLabels' => [
                                        'enabled' => true,
                                    ],
                                ],
                            ],
                            'series' => [
                                ['name' => 'Страницы', 'data' => array_values($data[Content::TYPE_PAGE]), 'color' => 'darkgrey',],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
