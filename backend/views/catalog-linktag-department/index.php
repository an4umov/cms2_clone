<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CatalogLinktagDepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ссылки на тег';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => $this->title,];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_LINKTAG_DEPARTMENT);
?>
<div class="catalog-linktag-department-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered',],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'link_tag',
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'link_tag',
                    'data' => $searchModel->getLinkTagOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать ...',
                        'multiple' => false,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            'code',
            'department_code',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at, "medium");
                },
            ],
        ],
    ]); ?>
</div>
