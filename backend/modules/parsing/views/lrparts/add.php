<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \common\components\helpers\ParserHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsRubrics */

$imageSrc = ParserHelper::getLrPartsDefaultImageUrl();
$imageInfo = ParserHelper::getLrPartsImageInfo($imageSrc);
?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/parsing/lrparts/add-rubric',]),
                'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'name' => 'form_lrparts_rubrics',],
            ]); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('is_active')?></label>
                <div class="col-sm-9">
                    <?= \kartik\checkbox\CheckboxX::widget([
                        'name' => 'ParserLrpartsRubrics[is_active]',
                        'value' => $model->is_active,
                        'options' => ['class' => 'form-control', 'id' => 'parserlrpartsrubrics-is_active'],
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
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('page_header')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'page_header', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextarea($model, 'description', ['rows' => 5, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- <div class="col-sm-6 pro-img-details">
                    <img src="<?= $imageSrc ?>" alt="">
                </div> -->
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
                app.addNotification('Рубрика добавлена. Обновите раздел для подгрузки изменений в дереве');
                app.getTreeAjaxContent('/parsing/lrparts/view?id='+response.id, {});
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