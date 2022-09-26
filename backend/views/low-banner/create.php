<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LowBanner */

$this->title = 'Создать баннер';
$this->params['breadcrumbs'][] = ['label' => 'Low Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="low-banner-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
