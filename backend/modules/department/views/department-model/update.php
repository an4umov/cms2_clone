<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentModel */
/* @var $searchModel common\models\search\DepartmentModelListSearch */
/* @var $dataProviderMenu yii\data\ActiveDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isAjax boolean */

$this->title = 'Изменить модель департамента: ' . $model->word_1 . ($model->word_2 ? ' '.$model->word_2 : '');
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Модели департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MODEL;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_MODEL);
?>
<div class="department-model-update">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'dataProviderMenu' => $dataProviderMenu,
        'isAjax' => $isAjax,
    ]) ?>
</div>
