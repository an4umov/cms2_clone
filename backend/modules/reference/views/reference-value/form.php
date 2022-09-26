<?php

use common\models\BlockField;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReferenceValue */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formID = 'form-reference-value-'.$action;
?>

<div class="reference-value-form">
    <? if ($model->reference_id): ?>
        <?php $form = ActiveForm::begin([
            'id' => $formID,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/reference/reference-value/'.$action,]),
        ]); ?>
        <?= $form->field($model, 'reference_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? if (!$model->isNewRecord): ?>
            <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 128,]) ?>
        <?php ActiveForm::end(); ?>
    <? else: ?>
        <div class="alert alert-block alert-danger fade in">
            <strong>Ошибка!</strong> Отсутствует обязательный параметр
        </div>
    <? endif; ?>
</div>
<script>
    var referenceValueForm = jQuery("#<?= $formID ?>");
    referenceValueForm.validate({
        rules: {
            "ReferenceValue[name]": {
                required: true,
                minlength: 1
            }
        },
        messages: {
            "ReferenceValue[name]": {
                required: "Введите значение",
                minlength: "Минимум 1 символ"
            }
        }
    });
</script>