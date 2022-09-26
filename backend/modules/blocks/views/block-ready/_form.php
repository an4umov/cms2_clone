<?php

use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\components\helpers\BlockHelper;
use kartik\dialog\Dialog;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\BlockReady */
/* @var $form yii\widgets\ActiveForm */
/* @var $field common\models\BlockField */

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
                        if (blockAddForm.valid()) {                
                            jQuery.when( app.sendAjaxForm('form-block-field-add') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Поле добавлено');
                                    app.loadBlockFields(".$model->id.");
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
                        if (blockAddForm.valid()) {                
                            jQuery.when( app.sendAjaxForm('form-block-field-update') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Поле изменено');
                                    app.loadBlockFields(".$model->id.");
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
        'libName' => 'krajeeDialogCustDelete', // a custom lib name
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DANGER,
            'title' => 'Удаление поля',
            'nl2br' => false,
        ],
    ]);
}
?>

<div class="block-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-success">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <? if (!$model->isNewRecord): ?>
                <div class="form-group field-block-id">
                    <label class="control-label" for="block-id"><?= $model->getAttributeLabel('id') ?></label>
                    <p><?= $model->id ?></p>
                </div>
            <? endif; ?>

            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
            <?= $form->field($model, 'block_id')->dropDownList($model->getExistsGlobalTypeOptions(), ['prompt' => 'Выбрать...',])->hint('При смене данного типа все сохраненные данные будут удалены') ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128,]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 3,]) ?>
        </div>
    </div>

    <? if (!$model->isNewRecord): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Поля & данные</h3></div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class="panel-body" id="block-ready-form-field-list">
            <?=  \backend\components\widgets\ContentBlockWidget::widget(['block' => $model->getBlockData(), 'index' => 1, 'isContent' => false,]); ?>
        </div>
    </div>
    <? else: ?>
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> Поля для заполнения появятся после выбора глобального типа и сохранения блока
    </div>
    <? endif; ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> '.'Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<? if (!$model->isNewRecord) {
    $js2 = '
    jQuery("body").on("click", ".panel .tools .fa-chevron-up", function () {
        var el = jQuery(this).closest(".panel").children(".panel-body");

        jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
        el.slideDown(200);
    });    
    jQuery("body").on("click", ".panel .tools .fa-chevron-down", function () {
        var el = jQuery(this).closest(".panel").children(".panel-body");
        
        jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
        el.slideUp(200);
    });    
    ';

    $this->registerJs($js2);
}