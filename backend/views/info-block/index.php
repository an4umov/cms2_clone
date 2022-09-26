<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Info Blocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-block-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Info Block', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
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
            [
                'attribute' => 'type',
                'content' => function ($item) {
                    return common\models\InfoBlock::getType($item->type);
                }
            ],
            'sort',
            [
                'label' => 'Код',
                'content' => function ($item) {
                    return "[info_block id={$item->id}]";
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{update}{delete}"],
        ],
    ]); ?>
</div>
