<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TagCategory */

$this->title = 'Create Tag Category';
$this->params['breadcrumbs'][] = ['label' => 'Tag Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
