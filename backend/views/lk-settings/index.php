<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LkSettings */

$this->title = 'Личный кабинет';

$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_LK,],];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_LK;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_LK);
?>
<div class="alert alert-info fade in">
    <strong>Подсказки к формам:</strong> эти подсказки появятся в формах личного кабинета на знаке <strong><i>(?)</i></strong>
</div>
<div class="lk-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'delivery_address')->textInput(['maxlength' => 255,]) ?>

    <?= $form->field($model, 'contractor_entity')->textInput(['maxlength' => 255,]) ?>

    <?= $form->field($model, 'contractor_person')->textInput(['maxlength' => 255,]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
