<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\CustomTag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Изменить тег: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TAG;

$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_TAGS);
?>
<div class="department-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>
</div>