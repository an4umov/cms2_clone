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
            <h4>Добавление подуровня для "<?= $parentModel->name ?>"</h4>
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/add-setting',]),
                'options' => ['class' => 'form-horizontal', 'name' => 'form_lrparts_rubrics',],
            ]); ?>

            <?= $form->field($model, 'parent_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'type', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('level')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'level', ['readonly' => true, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('name')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'name', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <?php echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-save-btn',]) ?>
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
                location.href = "<?= Url::to(['/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'?id=',]) ?>"+response.id;
            } else {
                if (!!response.message) {
                    app.addNotification(response.message);
                }
            }
        });

        return false;
    });
});
jQuery('#form-lrparts-rubrics-remove-btn').on('click', function () {
    location.href = '/cart/cart-settings';

    return false;
});
</script>