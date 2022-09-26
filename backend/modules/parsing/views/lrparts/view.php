<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
use zxbodya\yii2\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsRubrics */
/* @var $items \common\models\ParserLrpartsItems[] */

$imageSrc = $model->getImageSrc(true);
$imageInfo = \common\components\helpers\ParserHelper::getLrPartsImageInfo($imageSrc);

if (!$model->isNewRecord) {
    echo Dialog::widget([
        'libName' => 'krajeeDialogCustDelete', // a custom lib name
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DANGER,
            'title' => 'Удаление',
            'nl2br' => false,
        ],
    ]);

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
                            jQuery.when( app.sendAjaxForm('form-content-block-add') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Блок добавлен');
                                    app.loadLrPartsBlocks(".$model->id.", '');
                                    
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
}

$this->registerJs('tinyMCE.remove();');
?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/parsing/lrparts/update-rubric',]),
                'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'name' => 'form_lrparts_rubrics',],
            ]); ?>
            <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('is_active')?></label>
                <div class="col-sm-9">
                    <?= \kartik\checkbox\CheckboxX::widget([
                        'name' => 'ParserLrpartsRubrics[is_active]',
                        'value' => $model->is_active,
                        'options' => ['class' => 'form-control', 'id' => 'parserlrpartsrubrics-is_active-'.$model->id,],
                        'pluginOptions' => ['threeState' => false,],
                    ])  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('sort_field')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'sort_field', ['maxlength' => 20, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('id')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'id', ['disabled' => true, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('parent_id')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'parent_id', ['maxlength' => 10, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('name')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'name', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('title')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'title', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('url')?></label>
                <div class="col-sm-9">
                    <?= Html::textInput('ParserLrpartsRubrics[url]', $model->getUrl(), ['maxlength' => 255, 'disabled' => true, 'class' => 'form-control', 'readonly' => true,]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('page_header')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'page_header', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="alert alert-info fade in"  style="margin-bottom: 10px;">
                        <strong>Картинка</strong>: <?= $imageInfo['name'] ?>, размер: <?= $imageInfo['width'] ?>x<?= $imageInfo['height'] ?> px
                    </div>

                    <?= \backend\components\widgets\ImageGalleryWidget::widget([
                        'id' => Html::getInputId($model, 'serverImage'),
                        'initdir' => \common\components\helpers\ParserHelper::getLrpartsImagesRootPath(),
                        'dir' => \common\components\helpers\ParserHelper::getLrpartsImagesRootPath(),
                        'filename' => $imageSrc,
                        'filepath' => $imageInfo['name'],
                        'name' => Html::getInputName($model, 'serverImage'),
//                        'label' => $model->getAttributeLabel('image'),
                    ]); ?>

                    <?php echo Html::activeFileInput($model, 'imageFile', ['class' => 'btn btn-warning', 'id' => 'form-lrparts-rubrics-upload-btn', 'style' => 'margin: 10px 0 10px 0;',]) ?>

                    <? if (!$items): ?>
                        <?php echo Html::button(Html::tag('i', '', ['class' => 'fa fa-plus',]).' Добавить подрубрику', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-add-btn', 'style' => 'margin-bottom: 10px;margin-top: 20px;', 'data-pid' => $model->id,]) ?><br/>
                    <? endif; ?>
                    <? if ($model->is_last && !$items): ?>
                        <?= Html::button(Html::tag('i', '', ['class' => 'fa  fa-trash',]) . ' Удалить рубрику', ['class' => 'btn btn-danger', 'id' => 'form-lrparts-rubrics-delete-btn', 'data-id' => $model->id, 'style' => 'margin-bottom: 10px;margin-top: 20px;',]) ?>
                    <? endif; ?>
                </div>
            </div>

            <? if ($model->is_last): ?>
                <table class="table table-bordered table-striped table-condensed">
                    <caption>Товары <?= Html::button(Html::tag('i', '', ['class' => 'fa fa-plus',]), ['class' => 'btn btn-success', 'title' => 'Добавить товар', 'id' => 'form-lrparts-items-add-btn', 'style' => 'margin-right: 10px;', 'data-rid' => $model->id,]) ?></caption>
                    <thead>
                    <tr>
                        <th class="numeric">ID</th>
                        <th>Позиция</th>
                        <th>Название</th>
                        <th>Код</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? if ($items): ?>
                        <? foreach ($items as $item): ?>
                            <tr>
                                <td class="numeric"><?= $item->id ?></td>
                                <td><?= $item->position ?></td>
                                <td><a href="/parsing/lrparts/update?id=<?= $item->id ?>" class="lrparts-item-btn" data-id="<?= $item->id ?>"><?= $item->name ?></a></td>
                                <td><?= $item->code ?></td>
                                <td>
                                    <?= Html::button(Html::tag('i', '', ['class' => 'fa  fa-trash',]), ['class' => 'btn btn-danger', 'title' => 'Удалить товар', 'id' => 'form-lrparts-items-delete-btn', 'data-id' => $item->id, 'data-rid' => $item->rubric_id,]) ?>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    <? else: ?>
                        <tr>
                            <td colspan="5">
                                Нет данных
                            </td>
                        </tr>
                    <? endif; ?>
                    </tbody>
                </table>
            <? endif; ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-11"><h3 class="panel-title">Блоки</h3></div>
                        <div class="col-lg-1">
                            <a id="form-lrparts-rubrics-add-block-btn" class="btn btn-info btn-xs pull-right" href="#" data-rubric_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                            <?= Html::tag('div', Html::img('/img/loader2.gif', ['style' => 'display: none; width: 22px; vertical-align: middle; margin-right: 5px;',]), ['id' => 'content-loader', 'class' => 'content-loader', 'style' => 'display: inline-block; float: right;',]) ?>
                        </div>
                    </div>
                </div>
                <div class="panel-body" id="content-form-block-list"></div>
            </div>

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
                'name' => 'ParserLrpartsRubrics[description]',
                'value' => $model->description,
                'id' => $tinyID,
                'class' => 'form-control',
                'language' => 'ru',
            ];
            $description = TinyMce::widget($settings);

            $tinyID = 'tinymce-widget-description_bottom-'.$model->id;
            $settings['settings']['selector'] = '#'.$tinyID;
            $settings['name'] = 'ParserLrpartsRubrics[description_bottom]';
            $settings['id'] = $tinyID;
            $settings['value'] = $model->description_bottom;
            $descriptionBottom = TinyMce::widget($settings);

            ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description')?></label>
                <div class="col-sm-9">
                    <?//= Html::activeTextarea($model, 'description', ['rows' => 5, 'class' => 'form-control',]);  ?>
                    <?= $description;  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description_bottom')?></label>
                <div class="col-sm-9">
                    <?//= Html::activeTextarea($model, 'description_bottom', ['rows' => 5, 'class' => 'form-control',]);  ?>
                    <?= $descriptionBottom;  ?>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-12 control-label">
                    <?php echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-save-btn',]) ?>
                </label>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>

<script>
jQuery(function () {
    jQuery('#form-lrparts-rubrics-save-btn').on('click', function () {
        jQuery.when(app.sendAjaxFileForm('form_lrparts_rubrics') ).then(function( response, textStatus, jqXHR ) {
            if (!!response.ok) {
                app.addNotification('Рубрика сохранена. Обновите раздел для подгрузки изменений в дереве');

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

<?
    $js = 'app.loadLrPartsBlocks(' . $model->id . ');';
    $js2 = '
    jQuery("body").on("click", ".panel .tools .fa-chevron-up", function () {
        let btn = jQuery(this);
        let contentBlockID = btn.data("id");
        let blockType = btn.data("type");
        var el = btn.closest(".panel").children(".panel-body");

        btn.removeClass("fa-chevron-up").addClass("fa-chevron-down");
        el.slideDown(200);
        jQuery("#block-field-expanded-"+blockType+"-"+contentBlockID).val(1);
    });    
    jQuery("body").on("click", ".panel .tools .fa-chevron-down", function () {
        let btn = jQuery(this);
        let contentBlockID = btn.data("id");
        let blockType = btn.data("type");
        var el = btn.closest(".panel").children(".panel-body");
        
        btn.removeClass("fa-chevron-down").addClass("fa-chevron-up");
        el.slideUp(200);
        jQuery("#block-field-expanded-"+blockType+"-"+contentBlockID).val(0);
    });    
    ';

    $this->registerJs($js);
    $this->registerJs($js2);
    $this->registerCss('.sp-preview {margin-right: 0 !important;}');
