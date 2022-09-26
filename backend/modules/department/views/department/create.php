<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $isAjax boolean */
/* @var $model common\models\Department */

$this->title = 'Добавить департамент';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TREE;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT);
?>
<div class="department-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProviderMenu' => null,
        'dataProviderModel' => null,
        'isAjax' => $isAjax,
    ]) ?>
</div>
