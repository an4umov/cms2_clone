<?php

use yii\helpers\Html;
use backend\components\helpers\MenuHelper;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsFooterItem */

$this->title = 'Обновить пункт блока: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => '/settings',];
$this->params['breadcrumbs'][] = ['label' => 'Футер', 'url' => '/settings-footer',];
$this->params['breadcrumbs'][] = ['label' => 'Блок', 'url' => ['/settings-footer/update', 'id' => $model->footer_id,],];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id,]];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_FOOTER;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FOOTER);
?>
<div class="settings-footer-item-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
