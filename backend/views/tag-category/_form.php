<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TagCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon_type')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'selected')->checkbox() ?>

    <?= $form->field($model, 'disabled')->checkbox() ?>

    <?= $form->field($model, 'readonly')->checkbox() ?>

    <?= $form->field($model, 'visible')->checkbox() ?>

    <?= $form->field($model, 'collapsed')->checkbox() ?>

    <?= $form->field($model, 'movable_u')->checkbox() ?>

    <?= $form->field($model, 'movable_d')->checkbox() ?>

    <?= $form->field($model, 'movable_l')->checkbox() ?>

    <?= $form->field($model, 'movable_r')->checkbox() ?>

    <?= $form->field($model, 'removable')->checkbox() ?>

    <?= $form->field($model, 'removable_all')->checkbox() ?>

    <?= $form->field($model, 'child_allowed')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
