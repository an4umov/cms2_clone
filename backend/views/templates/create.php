<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = 'Создать шаблон';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php echo $this->render('_form', [
            'model' => $model,
            'staticTemplates' => $staticTemplates
        ]) ?>
    </div>
</div>
`