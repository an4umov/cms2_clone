<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */

$this->title = 'Редактировать пункт меню: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Пункты меню', 'url' => ['index']];
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
