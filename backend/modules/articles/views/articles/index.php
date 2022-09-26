<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?php echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'url_key:ntext',
            'deleted',
            'cache',
            'cache_time:datetime',
            //'create_time',
            //'last_change',
            //'title:ntext',
            //'description:ntext',
            //'announce:ntext',
            //'content:ntext',
            //'announce_image:ntext',
            //'order_num',
            //'show_on_the_main',
            //'main_category_id',
            //'video_announce:ntext',
            //'lr_articles:ntext',
            //'pageTitle:ntext',
            //'lr_checkResult:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
