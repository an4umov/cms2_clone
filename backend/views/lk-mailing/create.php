<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\LkMailing */

$this->title = 'Создать почтовую рассылку';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Почтовые рассылки', 'url' => ['/settings/mailing',]];
$this->params['breadcrumbs'][] = ['label' => $this->title,];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MAILING;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING);
?>
<div class="lk-mailing-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
