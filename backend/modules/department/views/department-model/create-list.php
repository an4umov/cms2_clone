<?php

use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentModelList */
/* @var $owner common\models\DepartmentModel */
/* @var $isAjax boolean */

$this->title = 'Добавить запись модели';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Модели департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Изменить модель: ' . $owner->word_1 . ($owner->word_2 ? ' '.$owner->word_2 : ''), 'url' => ['update', 'id' => $owner->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MODEL;
?>
<div class="department-model-list-create">
    <?= $this->render('_form-list', [
        'model' => $model,
        'owner' => $owner,
        'isAjax' => $isAjax,
    ]) ?>
</div>
