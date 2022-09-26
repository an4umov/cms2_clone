<?php

use backend\components\helpers\IconHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GreenMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="green-menu-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_enabled')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>

    <?= $form->field($model, 'is_department_menu')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
    <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Признак "<?= $model->getAttributeLabel('is_department_menu') ?>" может быть только у одной записи</small>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'landing_page_id')->dropDownList(\common\components\helpers\DepartmentHelper::getLandingPageOptions($model->landing_page_id), [
        $model->landing_page_id => ['selected' => true,], 'prompt' => 'Выберите страницу...',
    ]); ?>

    <?= $form->field($model, 'sort')->input('number', ['style' => 'width:100px;',]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
