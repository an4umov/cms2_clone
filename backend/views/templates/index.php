<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>
        <p>
            <?php echo Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                [
                    'attribute' => 'content',
                    'value' => function($model) {
                        return "<div style='background: #f8f8f8'>{$model->content}</div>";
                    },
                    'format' => 'html'
                ],
                'active',
                'type',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
