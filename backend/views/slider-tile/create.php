<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SliderTile */

$this->title = 'Create Slider Tile';
$this->params['breadcrumbs'][] = ['label' => 'Slider Tiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-tile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
