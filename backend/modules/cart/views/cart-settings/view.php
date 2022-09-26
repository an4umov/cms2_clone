<?php

use backend\components\helpers\MenuHelper;
use common\components\helpers\CartHelper;
use common\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use zxbodya\yii2\tinymce\TinyMce;
use common\models\CartSettings;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model common\models\CartSettings */

$this->registerJs("if (typeof tinyMCE !== 'undefined') { tinyMCE.remove(); }");
$hasChildrens = false;
if(!empty(CartHelper::getCartTreeDataChildrens($model->id))) {
    $hasChildrens = true;
}
?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/update',]),
                'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'name' => 'form_lrparts_rubrics',],
            ]); ?>
            <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'parent_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'level', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>

            <? if ($model->id === \common\components\helpers\CartHelper::CART_SETTINGS_GLOBAL_ID): ?>
                <h4>Глобальные настройки корзины</h4>
                <?
                    $data = $model->globalSettings->getData();
                    $successMessage = $data[Settings::CART_SUCCESS_MESSAGE_KEY] ?? Settings::CART_SUCCESS_DEFAULT;
                    $failureMessage = $data[Settings::CART_FAILURE_MESSAGE_KEY] ?? Settings::CART_FAILURE_DEFAULT;
                ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Успешная отправка заказа</label>
                    <div class="col-sm-9">
                        <?= Html::textInput(Settings::CART_SUCCESS_MESSAGE_KEY, $successMessage, ['class' => 'form-control',]);  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Неудачная отправка заказа</label>
                    <div class="col-sm-9">
                        <?= Html::textInput(Settings::CART_FAILURE_MESSAGE_KEY, $failureMessage, ['class' => 'form-control',])  ?>
                    </div>
                </div>
            <? else: ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('id')?></label>
                    <div class="col-sm-3">
                        <?= Html::activeTextInput($model, 'id', ['readonly' => true, 'class' => 'form-control',]);  ?>
                    </div>
                    <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('level')?></label>
                    <div class="col-sm-3">
                        <?= Html::activeTextInput($model, 'level', ['readonly' => true, 'class' => 'form-control',]);  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('name')?></label>
                    <div class="col-sm-9">
                        <?= Html::activeTextInput($model, 'name', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                    </div>
                </div>

                <? if ($model->level === CartSettings::LEVEL_1): ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('type')?></label>
                        <div class="col-sm-9">
                            <?= Html::activeDropDownList($model, 'type', $model->getAvailableStatuses(), ['class' => 'form-control', 'prompt' => 'Выбрать...',]);  ?>
                        </div>
                    </div>
                <? endif; ?>

                <? if ($model->level > CartSettings::LEVEL_1): ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('sort')?></label>
                        <div class="col-sm-9">
                            <?= Html::activeTextInput($model, 'sort', ['maxlength' => 20, 'class' => 'form-control',]);  ?>
                        </div>
                    </div>
                <? endif; ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('is_active')?></label>
                    <div class="col-sm-9">
                        <?= \kartik\checkbox\CheckboxX::widget([
                            'name' => 'CartSettings[is_active]',
                            'value' => (int) $model->is_active,
                            'options' => ['class' => 'form-control', 'id' => 'cartsettings-is_active-'.$model->id,],
                            'pluginOptions' => ['threeState' => false,],
                        ])  ?>
                    </div>
                </div>
                <? if ($model->level > CartSettings::LEVEL_1 || $model->id == 1): ?>
                    <?
                    $tinyID = 'tinymce-widget-description-'.$model->id;
                    $settings = [
                        'settings' => [
                            'height' => 100,
                            'plugins' => [
                                "textcolor link wordcount",
                            ],
                            'content_css' => '/css/tinymce.css',
                            "toolbar" => "undo redo | bold forecolor | removeformat | preview",
                            'selector' => '#'.$tinyID,
                            'menubar' => false,
                            'formats' => [
                                'removeformat' => [
                                    [
                                        'selector' => 'b,strong,em,i,font,u,strike,h1,h2,h3,h4,h5,h6,a',
                                        'remove' => 'all',
                                        'split' => true,
                                        'expand' => false,
                                        'block_expand' => true,
                                        'deep' => true,
                                    ],
                                    [
                                        'selector' => 'span',
                                        'attributes' => ['style', 'class',],
                                        'remove' => 'empty',
                                        'split' => true,
                                        'expand' => false,
                                        'deep' => true,
                                    ],
                                    [
                                        'selector' => '*',
                                        'attributes' => ['style', 'class',],
                                        'split' => false,
                                        'expand' => false,
                                        'deep' => true,
                                    ]
                                ],
                            ],
                            'setup' => new JsExpression("function (editor) {
                                editor.on('change', function () {
                                    tinymce.triggerSave();
                                });
                            }"),
                        ],
                        'name' => 'CartSettings[description]',
                        'value' => $model->description,
                        'id' => $tinyID,
                        'class' => 'form-control',
                        'language' => 'ru',
                    ];
                    $description = TinyMce::widget($settings);

                    ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description')?></label>
                        <div class="col-sm-9">
                            <?= $description;  ?>
                        </div>
                    </div>

                    <? if ($model->level === CartSettings::LEVEL_3): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('is_collapse')?></label>
                            <div class="col-sm-9">
                                <?= \kartik\checkbox\CheckboxX::widget([
                                    'name' => 'CartSettings[is_collapse]',
                                    'value' => (int) $model->is_collapse,
                                    'options' => ['class' => 'form-control', 'id' => 'cartsettings-is_collapse-'.$model->id,],
                                    'pluginOptions' => ['threeState' => false,],
                                ])  ?>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if ($model->level === CartSettings::LEVEL_4): ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group add-img-group">
                                    <div class="add-img-group__wrapper-select">
                                        <?php echo Html::activeFileInput($model, 'imageFile', ['class' => 'btn btn-warning', 'id' => 'form-lrparts-rubrics-upload-btn', 'style' => 'margin: 10px 0 10px 0;',]) ?>
                                    </div>
                                    <div class="add-img-group__wrapper-img">
                                        <? if ($model->image) {
                                            echo Html::img($model->getImageSrc(), ['alt' => $model->name,]);
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('radio_text')?></label>
                            <div class="col-sm-9">
                                <?= Html::activeTextInput($model, 'radio_text', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                            </div>
                        </div>
                    <? endif; ?>
                <? endif; ?>
            <? endif; ?>
            <div class="form-group">
                <div class="col-sm-12">                        
                    <?php echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-save-btn',]) ?>
                    <? if ($model->level < CartSettings::LEVEL_4): ?>
                        <?php echo Html::button(Html::tag('i', '', ['class' => 'fa fa-plus',]).' Добавить подуровень', ['class' => 'btn btn-info', 'id' => 'form-cart-settings-add-btn', 'style' => 'margin-left: 20px;', 'data-pid' => $model->id,]) ?>
                    <? endif; ?>
                    <?php 
                        if (!$hasChildrens) {
                    ?>
                    <?php echo Html::button(Html::tag('i', '', ['class' => 'fa fa-trash',]).' Удалить подуровень', ['class' => 'btn btn-danger pull-right', 'id' => 'form-cart-settings-remove-btn', 'data-id' => $model->id,]) ?>
                    <?php } ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
<?php 
    echo Dialog::widget([
        'libName' => 'krajeeDialogCustDelete',
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DANGER,
            'title' => 'Удаление значения',
            'nl2br' => false,
        ],
    ]);
            ?>
<script>
jQuery(function () {
    jQuery('#form-lrparts-rubrics-save-btn').on('click', function () {
        jQuery.when(app.sendAjaxFileForm('form_lrparts_rubrics') ).then(function( response, textStatus, jqXHR ) {
            if (!!response.ok) {
                if (!!app.lrpartsTreeActiveUrl) {
                    app.getTreeAjaxContent(app.lrpartsTreeActiveUrl, {});
                }
            } else {
                if (!!response.message) {
                    app.addNotification(response.message);
                }
            }
        });

        return false;
    });
});
</script>

<? $this->registerCss('.sp-preview {margin-right: 0 !important;}');