<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentModel */
/* @var $isAjax boolean */

$this->title = 'Добавить модель департамента';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Модели департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MODEL;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MODEL);
?>
<div class="department-model-create">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => null,
        'dataProvider' => null,
        'dataProviderMenu' => null,
        'isAjax' => $isAjax,
    ]) ?>
</div>
