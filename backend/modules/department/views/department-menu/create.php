<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenu */
/* @var $isAjax boolean */

$this->title = 'Добавить меню департамента';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Меню департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MENU;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MENU);
?>
<div class="department-menu-create">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => null,
        'dataProvider' => null,
        'isAjax' => $isAjax,
    ]) ?>
</div>
