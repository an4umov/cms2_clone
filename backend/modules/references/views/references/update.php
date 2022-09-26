<?php
/* @var $this yii\web\View */
/* @var $model common\models\References */

use backend\components\helpers\IconHelper;
use \common\components\helpers\ReferenceHelper;

$this->title = 'Изменить справочник ['.$model->getClassTitle().']: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/references',],];
$this->params['breadcrumbs'][] = ['label' => $model->getClassTitle(), 'url' => ['index',],];
$this->params['breadcrumbs'][] = $model->name;
$this->params['menuIcon'] = IconHelper::getSpanIcon(ReferenceHelper::getClassIcon());
?>
<div class="content-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
