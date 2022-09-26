<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $source string */
/* @var $model \common\models\Material */
/* @var $parentId mixed */

if (!isset($parentId)) {
    $parentId = false;
}

if (is_null($source)) {
    $source = false;
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'alias',
        //'content:ntext',
        [
            'label' => 'Тип',
            'attribute' => 'type_id',
            'content' => function ($model) {
                return \common\models\Material::getType($model->type_id);
            }
        ],
        //'status',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model) use ($parentId, $source) {
                    /** @var $model \common\models\Material */
                    if (!empty($parentId) && !empty($source) && $source == \common\models\Menu::SOURCE) {
                        //$url = $model->frontUrl($parentId);
                        $url = $model->frontUrl($parentId);
                    } else {
                        $url = yii\helpers\Url::to(['/material/view/', 'id' => $model->id]);
                    }
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon glyphicon-eye-open"></span>',
                        $url, [
                            'data-id' => $model->id,
                            'data-type' => 'flat',
                            'title' => 'View',
                            'aria-label' => 'View',
                        ]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        \yii\helpers\Url::to('/material/update?id=' . $model->id), [
                            'title' => 'Редактировать',
                            'aria-label' => 'Редактировать',
                            'data-pjax' => '0'
                        ]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        yii\helpers\Url::to('/material/delete/' . $model->id), [
                            'data-id' => $model->id,
                            'data-type' => 'flat',
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'class' => 'delete-object'
                        ]);
                },
            ],
            'template' => '{view}{update}{delete}'
        ],
    ],
]);