<?php

use kartik\color\ColorInput;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use zxbodya\yii2\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Form */
/* @var $form yii\widgets\ActiveForm */
if (!$model->isNewRecord) {
    echo Dialog::widget([
        'libName' => 'krajeeDialogCustomAdd',
        'options' => [
            'size' => Dialog::SIZE_WIDE,
            'type' => Dialog::TYPE_INFO,
            'title' => 'Добавление поля',
            'nl2br' => false,
            'buttons' => [
                [
                    'id' => 'cust-cancel-btn',
                    'label' => 'Отмена',
                    'cssClass' => 'btn-outline-secondary',
                    'hotkey' => 'C',
                    'action' => new JsExpression("function(dialog) {
                        return dialog.close();
                    }")
                ],
                [
                    'id' => 'cust-submit-btn',
                    'label' => 'Сохранить',
                    'cssClass' => 'btn-success',
                    'hotkey' => 'S',
                    'action' => new JsExpression("function(dialog) {
                        if (formFieldForm.valid()) {                
                            jQuery.when( app.sendAjaxForm('form-form-field-add') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Поле добавлено');
                                    app.loadFormFields(".$model->id.");
                                    return dialog.close();
                                } else {
                                    if (!!response.message) {
                                        app.addNotification(response.message);
                                    }
                                }
                            });
                        }                
                    }")
                ],
            ],
        ],
    ]);

    echo Dialog::widget([
        'libName' => 'krajeeDialogCustomUpdate',
        'options' => [
            'size' => Dialog::SIZE_WIDE,
            'type' => Dialog::TYPE_INFO,
            'title' => 'Редактирование поля',
            'nl2br' => false,
            'buttons' => [
                [
                    'id' => 'cust-cancel-btn',
                    'label' => 'Отмена',
                    'cssClass' => 'btn-outline-secondary',
                    'hotkey' => 'C',
                    'action' => new JsExpression("function(dialog) {
                        return dialog.close();
                    }")
                ],
                [
                    'id' => 'cust-submit-btn',
                    'label' => 'Сохранить',
                    'cssClass' => 'btn-success',
                    'hotkey' => 'S',
                    'action' => new JsExpression("function(dialog) {
                        if (formFieldForm.valid()) {                
                            jQuery.when( app.sendAjaxForm('form-form-field-update') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Поле изменено');
                                    app.loadFormFields(".$model->id.");
                                    return dialog.close();
                                } else {
                                    if (!!response.message) {
                                        app.addNotification(response.message);
                                    }
                                }
                            });
                        }                
                    }")
                ],
            ],
        ],
    ]);

    echo Dialog::widget([
        'libName' => 'krajeeDialogCustDelete',
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DANGER,
            'title' => 'Удаление поля',
            'nl2br' => false,
        ],
    ]);
}

$js = ' jQuery(".tagsinput").tagsInput();';
$this->registerJs($js, $this::POS_READY);
$this->registerCss('.input-group-sp.input-group-addon {min-width: 68px;}')
?>

<div class="form-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-success">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128,]) ?>
            <?= $form->field($model, 'css_prefix')->textInput(['maxlength' => 128,]) ?>
            <?= $form->field($model, 'color')->widget(ColorInput::class, [
                'options' => ['placeholder' => 'Выберите цвет ...'],
            ]); ?>

            <?= $form->field($model, 'color_bg')->widget(ColorInput::class, [
                'options' => ['placeholder' => 'Выберите цвет фона формы ...'],
            ]); ?>

            <div class="form-group field-form-emails" style="height: 43px; margin-bottom: 35px;">
                <label class="control-label" for="form-emails"><?= $model->getAttributeLabel('emails') ?></label><!-- mail@ya.ru,send@gmail.com -->
                <input type="text" id="form-emails" class="form-control tagsinput" name="Form[emails]" value="<?= $model->getEmailsAsString() ?>">
            </div>

            <?//= $form->field($model, 'emails')->textInput(['maxlength' => 128, 'class' => 'tagsinput', 'value' => $model->getEmailsAsString(),]) ?>
            <?php echo $form->field($model, 'result')->widget(TinyMce::class, [
                'settings' => [
                    'height' => 150,
                    'plugins' => [
                        "advlist lists hr pagebreak preview",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime nonbreaking save table contextmenu directionality",
                        "template paste textcolor code wordcount",
                    ],
                    'content_css' => '/css/tinymce.css',
                    "toolbar" => "undo redo | bold italic | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | removeformat | preview code",
                    'selector' => "textarea#editable",
                    'menubar' => false,
                    'formats' => [
                        'removeformat' => [
                            ['selector' => 'b,strong,em,i,font,u,strike,h1,h2,h3,h4,h5,h6', 'remove' => 'all', 'split' => true, 'expand' => false, 'block_expand' => true, 'deep' => true,],
                            ['selector' => 'span', 'attributes' => ['style', 'class',], 'remove' => 'empty', 'split' => true, 'expand' => false, 'deep' => true,],
                            ['selector' => '*', 'attributes' => ['style', 'class',], 'split' => false, 'expand' => false, 'deep' => true,]
                        ],
                    ],
                ],
                'language' => 'ru',
                'class' => 'form-control',
            ]); ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 3,]) ?>
        </div>
    </div>
    <? if (!$model->isNewRecord): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Поля</h3></div>
                    <div class="col-lg-1">
                        <a id="form-field-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-form_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="form-field-form-list"><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка данных...</div>
        </div>
    <? endif; ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<? if (!$model->isNewRecord) {
    $js = 'app.loadFormFields('.$model->id.');';

    $this->registerJs($js);
}