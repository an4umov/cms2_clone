<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $type mixed */
/* @var $model common\models\Widget */

$this->title = 'Create Widget';
$this->params['breadcrumbs'][] = ['label' => 'Widgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type
    ]) ?>

</div>
