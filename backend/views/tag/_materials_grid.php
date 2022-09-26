<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'alias',
        'content:ntext',
        'type_id',
        //'status',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a('<span class="glyphicon eye-open"></span>',
                        yii\helpers\Url::to('/material/view/' . $model->id), [
                            'data-id' => $model->id,
                            'data-type' => 'flat',
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'class' => 'delete-object'
                        ]);
                },
            ],
            'template' => '{view}'
        ],
    ],
]); ?>