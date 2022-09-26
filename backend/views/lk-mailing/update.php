<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LkMailing */

$this->title = 'Изменить почтовую рассылку: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index',],];
$this->params['breadcrumbs'][] = ['label' => 'Почтовые рассылки', 'url' => ['/settings/mailing',]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => $this->title,];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MAILING;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING);
?>
<div class="lk-mailing-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
