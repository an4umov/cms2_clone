<?php

use backend\components\widgets\ImageGalleryWidget;
use common\components\helpers\ContentHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenuTag */
/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel common\models\search\DepartmentMenuTagListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isAjax boolean */
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-menu-tag-form">
    <?php $form = ActiveForm::begin(['id' => 'department-menu-tag-form', 'enableClientValidation' => true,]); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax) ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id')->textInput(['maxlength' => 5, 'disabled' => true,]) ?>
        </div>
        <div class="col-md-5">
            <?= $form
                ->field($model, 'department_menu_id')
                ->widget(\kartik\select2\Select2::class, [
                    'data' => \common\models\DepartmentMenuTag::getMenuOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать меню...',
                        'multiple' => false,
                        'disabled' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                    'hideSearch' => true,
                ]);
            ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'url')->textInput(['maxlength' => 25,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'landing_page_id')->dropDownList(\common\components\helpers\DepartmentHelper::getLandingPageOptions($model->landing_page_id), [
                $model->landing_page_id => ['selected' => true,], 'prompt' => 'Выберите страницу...',
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= ImageGalleryWidget::widget([
                'id' => Html::getInputId($model, 'image'),
                'initdir' => ContentHelper::getImagesRootPath(),
                'dir' => ContentHelper::getImagesRootPath(),
                'filename' => $model->image ? substr($model->image, strrpos($model->image, DIRECTORY_SEPARATOR) + 1) : '',
                'filepath' => $model->image,
                'name' => Html::getInputName($model, 'image'),
                'label' => $model->getAttributeLabel('image'),
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'sort')->input('number') ?>
        </div>
        <div class="col-md-6" style="padding-top:27px;">
            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
