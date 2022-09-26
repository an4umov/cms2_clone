<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Material */

$this->title = 'Создать материал';
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php echo $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
