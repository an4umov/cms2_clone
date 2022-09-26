<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Composite */

$this->title = 'Составной блок контента';
$this->params['breadcrumbs'][] = ['label' => 'Составной блок контента', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="composite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
