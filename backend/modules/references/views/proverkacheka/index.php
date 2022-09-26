<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ParserProverkachekaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проверка чека';
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/references',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PROVERKACHEKA);

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_REFERENCES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_REFERENCES_PROVERKACHEKA;
?>
<div class="department-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'number',
            'inn',
            'total',
            [
                'attribute' => 'type',
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'data' => $searchModel->getFilterTypeOptions(),
                    'options' => [
//                        'placeholder' => 'Выбрать ...',
                        'multiple' => false,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
            ],
        ],
    ]); ?>
</div>
