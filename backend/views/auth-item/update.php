<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = 'Редактирование роли: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="auth-item-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
