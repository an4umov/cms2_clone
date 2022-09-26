<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Низкий баннер';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="low-banner-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Создать баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'color',
                'content' => function ($item) {
                    return "<span style='background-color: {$item->color}'>$item->color</span>";
                }
            ],
            'image',
            'title',
            'text',
            [
                'label' => 'Код',
                'content' => function ($item) {
                    return "[low_banner id={$item->id}]";
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{update}{delete}"],
        ],
    ]); ?>
</div>
