<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Composite */

$this->title = 'Редактировать блок: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Составной блок контента', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="composite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
