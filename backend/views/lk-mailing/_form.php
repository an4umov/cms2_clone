<?php

use backend\components\helpers\IconHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LkMailing */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="lk-mailing-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'sort')->input('number', ['style' => 'width:100px;',]) ?>
    <div class="form-group">
        <?= Html::submitButton('<span class="'.IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
