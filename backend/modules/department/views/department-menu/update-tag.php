<?php

use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenuTag */
/* @var $owner common\models\DepartmentMenu */
/* @var $searchModel common\models\search\DepartmentMenuTagListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isAjax boolean */

$this->title = 'Изменить тематику "'.$model->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Меню департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Изменить меню: ' . $owner->name, 'url' => ['update', 'id' => $owner->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MENU;
?>
<div class="department-menu-tag-update">
    <?= $this->render('_form-tag', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'isAjax' => $isAjax,
    ]) ?>
</div>
