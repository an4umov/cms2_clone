<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogTreeSetting */

$this->title = 'Изменить настройки каталога тип: плитка';
$this->params['breadcrumbs'][] = ['label' => $this->title,];
?>
<div class="tile-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
