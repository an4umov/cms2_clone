<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reference */

$this->title = 'Изменить справочник: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_REFERENCES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_REFERENCES_REFERENCE;
$this->params['menuIcon'] = IconHelper::getSpanIcon(\common\components\helpers\ReferenceHelper::getClassIcon());
?>
<div class="reference-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
