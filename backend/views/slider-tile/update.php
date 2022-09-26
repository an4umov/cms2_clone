<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SliderTile */

$this->title = 'Update Slider Tile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slider Tiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slider-tile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
