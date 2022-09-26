<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenuTagList */
/* @var $owner common\models\DepartmentMenuTag */
/* @var $form yii\widgets\ActiveForm */
/* @var $isAjax boolean */
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-menu-tag-list-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model, 'department_menu_tag_id')
                ->widget(\kartik\select2\Select2::class, [
                    'data' => \common\models\DepartmentMenuTagList::getDepartmentMenuTagOptions($owner->department_menu_id),
                    'options' => [
                        'placeholder' => 'Выбрать тематику...',
                        'multiple' => false,
                        'disabled' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                    'hideSearch' => true,
                ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'url')->textInput(['maxlength' => 25,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 50,]) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group field-department-menu-tag-list-icon">
                <label class="control-label" for="department-menu-tag-list-icon"><?= $model->getAttributeLabel('icon') ?></label>
                <? if ($model->icon): ?>
                <div class="iconic-input right">
                    <i class="<?= $model->icon ?>"></i>
                <? endif; ?>
                    <?= Html::textInput('DepartmentMenuTagList[icon]', $model->icon, ['class' => 'form-control', 'maxlength' => 50, 'id' => 'department-menu-tag-list-icon',]) ?>
                <? if ($model->icon): ?>
                </div>
                <? endif; ?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sort')->input('number') ?>
        </div>
    </div>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
