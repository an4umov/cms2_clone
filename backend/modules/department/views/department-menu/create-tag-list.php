<?php
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenuTagList */
/* @var $owner common\models\DepartmentMenuTag */
/* @var $isAjax boolean */

$this->title = 'Добавить запись тематики';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Меню департаментов', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Изменить меню: ' . $owner->departmentMenu->name, 'url' => ['update', 'id' => $owner->department_menu_id,],];
$this->params['breadcrumbs'][] = ['label' => 'Изменить тематику: #' . $owner->id, 'url' => ['update-tag', 'id' => $owner->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_MENU;
?>
<div class="department-menu-tag-list-create">
    <?= $this->render('_form-tag-list', [
        'model' => $model,
        'owner' => $owner,
        'isAjax' => $isAjax,
    ]) ?>
</div>
