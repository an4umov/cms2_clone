<?php

use yii\helpers\Html;
use backend\components\helpers\MenuHelper;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsFooter */

$this->title = 'Создать блок';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => '/settings',];
$this->params['breadcrumbs'][] = ['label' => 'Футер', 'url' => ['index'],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_FOOTER;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FOOTER);
?>
<div class="settings-footer-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
