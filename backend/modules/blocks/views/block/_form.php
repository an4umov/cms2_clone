<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\components\helpers\BlockHelper;
use kartik\dialog\Dialog;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $form yii\widgets\ActiveForm */
/* @var $field common\models\BlockField */

$widgetID = 'dialog-block-field-list-'.time();
echo Html::style('#'.$widgetID.' div.modal-dialog {width: 50%;}');

if (!$model->isNewRecord) {
    echo Dialog::widget([
        'id' => $widgetID,
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
        'id' => $widgetID,
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
    <? //= $form->field($model, 'type', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>

    <div class="panel panel-success">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <? if (!$model->isNewRecord): ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group field-block-id">
                        <label class="control-label" for="block-id"><?= $model->getAttributeLabel('id') ?></label>
                        <p><?= $model->id ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-block-type">
                        <label class="control-label" for="block-type"><?= $model->getAttributeLabel('type') ?></label>
                        <p><?= BlockHelper::getBlockTypeTitle($model->type) ?></p>
                    </div>
                </div>
            </div>
            <? else: ?>
                <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
            <? endif; ?>

            <?= $form->field($model, 'global_type')->dropDownList($model->getExistsGlobalTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 3,]) ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Поля</h3></div>
                <div class="col-lg-1">
                    <? if (!$model->isNewRecord): ?>
                        <a id="block-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-block_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                        <?= Html::tag('div', Html::img('/img/loader2.gif', ['style' => 'display: none; width: 22px; vertical-align: middle; margin-right: 5px;',]), ['id' => 'block-loader', 'class' => 'block-loader', 'style' => 'display: inline-block; float: right;',]) ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
        <div class="panel-body" id="block-form-field-list"><? if ($model->isNewRecord): ?><span class="fa fa-info-circle text-primary"></span> Сохраните блок для добавления полей<? else: ?><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка данных...<? endif; ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> '.'Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<? if (!$model->isNewRecord) {
    $js = 'app.loadBlockFields('.$model->id.');';

    $this->registerJs($js);
}