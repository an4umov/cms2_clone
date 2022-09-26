<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tile */

$this->title = 'Create Tile';
$this->params['breadcrumbs'][] = ['label' => 'Tiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
