<?php

use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentModelList */
/* @var $owner common\models\DepartmentModel */
/* @var $form yii\widgets\ActiveForm */
/* @var $isAjax boolean */
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-model-list-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax) ?>

    <?= $form
        ->field($model, 'department_model_id')
        ->widget(\kartik\select2\Select2::class, [
            'data' => \common\models\DepartmentModel::getModelOptions(),
            'options' => [
                'placeholder' => 'Выбрать модель...',
                'multiple' => false,
                'disabled' => true,
            ],
            'pluginOptions' => [
                'allowClear' => false,
            ],
            'hideSearch' => true,
        ]);
    ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'url')->textInput(['maxlength' => 25,]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group field-departmentmodellist-icon">
                <label class="control-label" for="departmentmodellist-icon"><?= $model->getAttributeLabel('icon') ?></label>
                <? if ($model->icon): ?>
                <div class="iconic-input right">
                    <i class="<?= $model->icon ?>"></i>
                    <? endif; ?>
                    <?= Html::textInput('DepartmentModelList[icon]', $model->icon, ['class' => 'form-control', 'maxlength' => 50, 'id' => 'departmentmodellist-icon',]) ?>
                    <? if ($model->icon): ?>
                </div>
            <? endif; ?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
