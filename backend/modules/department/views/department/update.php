<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $isAjax boolean */
/* @var $dataProviderMenu yii\data\ActiveDataProvider */

$this->title = 'Изменить департамент: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Департаменты', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT);
?>
<div class="department-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProviderMenu' => $dataProviderMenu,
        'isAjax' => $isAjax,
    ]) ?>
</div>