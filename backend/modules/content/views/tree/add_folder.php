<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsRubrics */
/* @var $parentModel common\models\ParserLrpartsRubrics */

?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <h4>Виртуальная подпапка для "<?= $parentModel->name ?>"</h4>
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/add-folder?pid='.$parentModel->id,]),
                'options' => ['class' => 'form-horizontal', 'name' => 'form_lrparts_rubrics',],
            ]); ?>

            <?= $form->field($model, 'parent_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('name')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'name', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextarea($model, 'description', ['rows' => 5, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <?php echo Html::button('Добавить', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-save-btn',]) ?>
                    <?php echo Html::button('Отменить', ['class' => 'btn btn-warning pull-right', 'id' => 'form-lrparts-rubrics-remove-btn',]) ?>
                </div>
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
                // app.refreshPage(0);
                location.href = "<?= Url::to(['/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'?id=',]) ?>"+response.id;
            } else {
                if (!!response.message) {
                    app.addError(response.message);
                }
            }
        });

        return false;
    });
});
jQuery('#form-lrparts-rubrics-remove-btn').on('click', function () {
    location.href = '/content/tree';

    return false;
});
</script>