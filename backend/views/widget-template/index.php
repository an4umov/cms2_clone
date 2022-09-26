<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Widget Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-template-index">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?php echo Html::a('Create Widget Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'content:ntext',
            'fields',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
