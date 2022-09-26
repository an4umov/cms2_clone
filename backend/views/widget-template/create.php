<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetTemplate */

$this->title = 'Create Widget Template';
$this->params['breadcrumbs'][] = ['label' => 'Widget Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-template-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
