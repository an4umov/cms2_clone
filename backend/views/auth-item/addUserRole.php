<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AuthAssignment */

$this->title = 'Изменить роль у пользователя: ' . $model->user_id;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_formUserRole', [
        'model' => $model,
    ]) ?>

</div>
