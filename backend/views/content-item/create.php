<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContentItem */
/* @var $type integer */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Контент для блоков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type
    ]) ?>

</div>
