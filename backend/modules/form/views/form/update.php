<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Form */

$this->title = 'Изменить форму: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS,],];
$this->params['breadcrumbs'][] = ['label' => 'Формы', 'url' => ['index',],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_FORMS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FORM);
?>
<div class="form-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
