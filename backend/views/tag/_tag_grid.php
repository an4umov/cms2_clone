<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $parentId mixed */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>

        <p>
            <?php echo Html::a('Создать тег', \yii\helpers\Url::to(['tag/create', 'category_id' => $parentId]), ['class' => 'btn btn-success']) ?>
        </p>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'Название',
                    'attribute' => 'name',
                    /** @var \common\models\Tag $tag */
                    'content' => function ($tag) {
                        return Html::a($tag->name, \yii\helpers\Url::to(['/tag/view', 'id' => $tag->id]), [
                            'target' => '_blank'
                        ]);
                    }
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'update' => function ($url, $model) use ($parentId) {
                            return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                \yii\helpers\Url::to('/tag/update?category_id=' . $parentId . '&id=' . $model->id), [
                                    'title' => 'Редактировать',
                                    'aria-label' => 'Редактировать',
                                    'data-pjax' => '0'
                                ]);
                        },
                        'delete' => function ($url, $model) {
                            return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                yii\helpers\Url::to('/tag/delete/' . $model->id), [
                                    'data-id' => $model->id,
                                    'data-type' => 'flat',
                                    'title' => 'Удалить',
                                    'aria-label' => 'Удалить',
                                    'class' => 'delete-object'
                                ]);
                        },
                    ],
                    'template' => '{update}{delete}'
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
