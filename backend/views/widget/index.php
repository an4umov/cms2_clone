<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Widget ;

/* @var $this yii\web\View */
/* @var $type mixed */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Widget::type($type);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Widget', ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'title',
            'description',
            'text:ntext',
            [
                'label' => "Код",
                'content' => function ($item) {
                    return $item->shortcode();
                }
            ],
            //'created_at',
            //'updated_at',

            [
                    'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                        'update' => function ($url, $model, $key) use ($type) {
                            return Html::a('', [$url . "&type=$type"], ['class' => 'glyphicon glyphicon-pencil']);
                        },
                    'delete' => function ($url, $model, $key) use ($type) {
                        return Html::a('', [$url . "&type=$type"], ['class' => 'glyphicon glyphicon-trash']);
                    }
                ],
                'template' => '{update}{delete}'
            ],
        ],
    ]); ?>
</div>
