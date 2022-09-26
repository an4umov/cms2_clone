<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsFooter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-footer-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 255,]) ?>
    <?= $form->field($model, 'is_active')->widget(\kartik\checkbox\CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
    <div class="form-group">
        <?= Html::submitButton('<span class="'.IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
