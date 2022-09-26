<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = 'Добавить тег';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TAG;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_TAGS);
?>
<div class="department-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => null,
    ]) ?>
</div>
