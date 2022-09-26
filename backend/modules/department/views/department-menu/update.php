<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenu */
/* @var $searchModel common\models\search\DepartmentModelListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isAjax boolean */

$this->title = 'Изменить меню департамента: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Меню департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MENU;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MENU);
?>
<div class="department-menu-update">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'isAjax' => $isAjax,
    ]) ?>
</div>
