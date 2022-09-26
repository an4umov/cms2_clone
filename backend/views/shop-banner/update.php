<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopBanner */

$this->title = 'Редактировать баннер: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Низкий баннер', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="low-banner-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
