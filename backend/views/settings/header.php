<?php

use backend\components\helpers\MenuHelper;
use common\models\Content;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Content */

$this->title = 'Header';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_HEADER,],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_HEADER;
?>
<div class="content-update">
    <?= $this->render('_form', [
        'model' => $model,
        'title' => $this->title,
    ]) ?>
</div>