<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetTemplate */

$this->title = 'Update Widget Template: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Widget Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="widget-template-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
