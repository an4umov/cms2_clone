<?php

use common\models\BlockField;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use zxbodya\yii2\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\BlockField */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formID = 'form-block-field-'.$action;

if (!$model->isNewRecord) {
    if ($model->type === BlockField::TYPE_LIST || $model->type === BlockField::TYPE_RADIO) {
        $js = 'app.loadBlockFieldList(' . $model->id . ');';
        $this->registerJs($js);
    } elseif ($model->type === BlockField::TYPE_VALUES_LIST) {
        $js = 'app.loadBlockFieldValuesList(' . $model->id . ');';
        $this->registerJs($js);
    }
}
$this->registerJs("if (typeof tinyMCE !== 'undefined') { tinyMCE.remove(); }");
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

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled' => !$model->isNewRecord,]) ?>
        <? if ($model->type === BlockField::TYPE_RADIO): ?>
        <?= $form->field($model, 'name_id')->textInput(['maxlength' => true,]) ?>
        <? endif; ?>

        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
        <?= $form->field($model, 'description')->textInput() ?>
        <? if ($model->type === BlockField::TYPE_RADIO): ?>
            <label class="control-label"><?= $model->getAttributeLabel('info')?></label>
            <?php 
                $tinyID = 'tinymce-widget-info-'.$model->id;
                $settings = [
                    'settings' => [
                        'height' => 100,
                        'plugins' => [
                            "textcolor link wordcount",
                        ],
                        'content_css' => '/css/tinymce.css',
                        "toolbar" => "undo redo | bold forecolor | bullist",
                        'selector' => '#'.$tinyID,
                        'menubar' => false,
                    ],
                    'name' => 'BlockField[info]',
                    'value' => $model->info,
                    'id' => $tinyID,
                    'class' => 'form-control',
                    'language' => 'ru',
                ];
                $description = TinyMce::widget($settings);
                echo $description;
            ?>
            <br>
        <? endif; ?>
        <div id="form-block-field-list-container">
            <? if ($model->type === BlockField::TYPE_LIST || $model->type === BlockField::TYPE_VALUES_LIST || $model->type === BlockField::TYPE_RADIO): ?><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка элементов списка...<? endif; ?>
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