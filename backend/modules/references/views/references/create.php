<?php
/* @var $this yii\web\View */
/* @var $model common\models\References */

use backend\components\helpers\IconHelper;

$this->title = 'Добавить справочник';
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/references',],];
$this->params['breadcrumbs'][] = ['label' => $model->getClassTitle(), 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon(\common\components\helpers\ReferenceHelper::getClassIcon());
?>
<div class="references-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>