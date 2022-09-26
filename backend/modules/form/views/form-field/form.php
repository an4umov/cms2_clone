<?php

use \common\components\helpers\FormHelper;
use \common\models\FormField;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\FormField */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formID = 'form-form-field-'.$action;
$data = $model->data ? Json::decode($model->data) : [];
?>

<div class="form-field-form">
    <? if ($model->form_id): ?>
        <?php $form = ActiveForm::begin([
            'id' => $formID,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/form/form-field/'.$action,]),
        ]); ?>
        <?= $form->field($model, 'form_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? if (!$model->isNewRecord): ?>
            <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 128,]) ?>
        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['prompt' => 'Выбрать...', 'id' => 'form-form-field-type',]) ?>
        <div id="form-form-field-list-container"></div>
        <?php ActiveForm::end(); ?>
    <? else: ?>
        <div class="alert alert-block alert-danger fade in">
            <strong>Ошибка!</strong> Отсутствует обязательный параметр
        </div>
    <? endif; ?>
</div>
<script>
    var formFieldForm = jQuery("#<?= $formID ?>");
    formFieldForm.validate({
        rules: {
            "FormField[name]": {
                required: true,
                minlength: 1
            },
            "FormField[type]": "required"
        },
        messages: {
            "FormField[name]": {
                required: "Введите значение",
                minlength: "Минимум 1 символ"
            },
            "FormField[type]": "Выберите тип"
        }
    });

    var types = {};
    <? foreach (FormField::TYPES as $type) {
        $html = FormHelper::getFormFieldTypeFields($type, $data, $this);
        echo 'types["'.$type.'"] = \''.$html.'\';'.PHP_EOL;
    } ?>

    jQuery('#form-form-field-type').on("change", function () {
        let select = jQuery(this);
        let value = select.val();

        if (value && !!types[value]) {
            jQuery('#form-form-field-list-container').html(types[value]);
            if (value === '<?= FormField::TYPE_MESSAGE ?>') {
                $('#'+fieldWisiwigSettings.id).tinymce(fieldWisiwigSettings);
            }
        } else {
            jQuery('#form-form-field-list-container').html('');
        }
    });

    jQuery('#form-form-field-type').change();
</script>