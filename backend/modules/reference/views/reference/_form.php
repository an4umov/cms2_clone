<?php

use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reference */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    echo Dialog::widget([
        'libName' => 'krajeeDialogCustomAdd',
        'options' => [
            'size' => Dialog::SIZE_WIDE,
            'type' => Dialog::TYPE_INFO,
            'title' => 'Добавление значения',
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
                            jQuery.when( app.sendAjaxForm('form-reference-value-add') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Значение добавлено');
                                    app.loadReferenceValues(".$model->id.");
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
            'title' => 'Редактирование значения',
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
                            jQuery.when( app.sendAjaxForm('form-reference-value-update') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Значение изменено');
                                    app.loadReferenceValues(".$model->id.");
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
            'title' => 'Удаление значения',
            'nl2br' => false,
        ],
    ]);
}
?>

<div class="reference-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-success">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128,]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 3,]) ?>
            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
        </div>
    </div>

    <? if (!$model->isNewRecord): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Значения</h3></div>
                <div class="col-lg-1">
                    <a id="reference-value-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-reference_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="panel-body" id="reference-value-form-list"><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка данных...</div>
    </div>
    <? endif; ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<? if (!$model->isNewRecord) {
    $js = 'app.loadReferenceValues('.$model->id.');';

    $this->registerJs($js);
}