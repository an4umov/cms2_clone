<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдер';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Создать слайдер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',
            [
                'label' => 'Код',
                'content' => function ($item) {
                    return "[gallery id={$item->id}]";
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{update}{delete}"],
        ],
    ]); ?>
</div>
