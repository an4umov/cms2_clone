<?php

use backend\components\helpers\MenuHelper;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Макросы';
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MACRO;
?>
<div class="content-update">
    <div class="settings-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => 'Кнопка',
                    'content' => $this->render('_macro_button'),
                    'active' => true,
                ],
                [
                    'label' => 'Нечто',
                    'content' => $this->render('_thing_button'),
                    'active' => false,
                ],
            ],
        ]);
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>