<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Менеджеры';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_ADMIN_MANAGERS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_MODERATOR);
?>
<div class="alert alert-danger" role="alert">
    Страница в разработке
</div>