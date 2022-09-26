<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Material */

$this->title = 'Редактировать материал: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="box">
    <div class="box-body">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
