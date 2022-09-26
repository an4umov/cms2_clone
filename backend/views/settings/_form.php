<?php

use common\models\ContentFilter;
use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use \common\models\Content;
use \common\components\helpers\BlockHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $form yii\widgets\ActiveForm */
/* @var $title string */

$this->title = $title;

echo Dialog::widget([
    'libName' => 'krajeeDialogContentAdd',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_INFO,
        'title' => 'Добавление блока',
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
                        jQuery.when( app.sendAjaxForm('form-content-block-add-setting') ).then(function( response, textStatus, jqXHR ) {
                            if (!!response.ok) {
                                app.addNotification('Блок добавлен');
                                app.loadContentBlocks(".$model->id.", '');
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
    'libName' => 'krajeeDialogContentDelete',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_DANGER,
        'title' => 'Удаление блока',
        'nl2br' => false,
    ],
]);

?>
<div class="content-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group field-content-id">
                        <label class="control-label" for="content-id"><?= $model->getAttributeLabel('id') ?></label>
                        <p><?= $model->id ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-content-type">
                        <label class="control-label" for="content-type"><?= $model->getAttributeLabel('type') ?></label>
                        <p>Настройка</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-content-type">
                        <label class="control-label" for="content-type"><?= $model->getAttributeLabel('name') ?></label>
                        <p><?= $model->name ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Блоки</h3></div>
                <div class="col-lg-1">
                    <a id="content-setting-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-content_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                    <?= Html::tag('div', Html::img('/img/loader2.gif', ['style' => 'display: none; width: 22px; vertical-align: middle; margin-right: 5px;',]), ['id' => 'content-loader', 'class' => 'content-loader', 'style' => 'display: inline-block; float: right;',]) ?>
                </div>
            </div>
        </div>
        <div class="panel-body" id="content-form-block-list"><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка данных...</div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<? $js = 'app.loadContentBlocks(' . $model->id . ', "");';
    $this->registerJs($js);
    $this->registerCss('.sp-preview {margin-right: 0 !important;}');

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
