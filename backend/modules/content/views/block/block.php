<?php

use common\models\BlockField;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BlockField */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formID = 'form-block-field-'.$action;

if (!$model->isNewRecord && $model->type === BlockField::TYPE_LIST) {
    $js = 'app.loadBlockFieldList(' . $model->id . ');';

    $this->registerJs($js);
}
?>

<div class="block-form">
    <? if ($model->block_id): ?>
        <?php $form = ActiveForm::begin([
            'id' => $formID,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/blocks/field/'.$action,]),
        ]); ?>
        <?= $form->field($model, 'block_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? if (!$model->isNewRecord): ?>
            <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <? endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
        <div id="form-block-field-list-container">
            <? if ($model->type === BlockField::TYPE_LIST): ?><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка элементов списка...<? endif; ?>
        </div>
        <?php ActiveForm::end(); ?>
    <? else: ?>
        <div class="alert alert-block alert-danger fade in">
            <strong>Ошибка!</strong> Отсутствует обязательный параметр
        </div>
    <? endif; ?>
</div>
<script>
    var blockAddForm = jQuery("#<?= $formID ?>");
    blockAddForm.validate({
        rules: {
            "BlockField[name]": {
                required: true,
                minlength: 3
            },
            "BlockField[type]": "required"
        },
        messages: {
            "BlockField[type]": "Выберите тип",
            "BlockField[name]": {
                required: "Введите название поля",
                minlength: "Минимум 3 символа"
            }
        }
    });
</script>