<?php

use backend\components\widgets\ImageGalleryWidget;
use common\components\helpers\ContentHelper;
use kartik\checkbox\CheckboxX;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentMenu */
/* @var $form yii\widgets\ActiveForm */
/* @var $isAjax boolean */

$isLandingMenu = $model->isLandingMenu();
$js = "
jQuery('#landing-page-type').on('change', function () {
    let value = jQuery(this).val();
    let landingPageIDSelect = jQuery('#landing-page-id');
    let landingPageCatalogSelect = jQuery('#landing-page-catalog');

    console.log('value = '+value);
    console.log(landingPageIDSelect);
    console.log(landingPageCatalogSelect);

    if (value === '".$model::LANDING_PAGE_TYPE_CATALOG."') {
        landingPageCatalogSelect.removeAttr('disabled');
        landingPageIDSelect.attr('disabled', 'true');
    } else if (value === '".$model::LANDING_PAGE_TYPE_PAGE."') {
        landingPageIDSelect.removeAttr('disabled');
        landingPageCatalogSelect.attr('disabled', 'true');
    } else {
        landingPageIDSelect.attr('disabled', 'true');
        landingPageCatalogSelect.attr('disabled', 'true');
    }
});";

$this->registerJs($js, $this::POS_READY);
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-menu-form">
    <?php $form = ActiveForm::begin(['id' => 'department-menu-form', 'enableClientValidation' => true,]); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax) ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id')->textInput(['maxlength' => 5, 'disabled' => true,]) ?>
        </div>
        <div class="col-md-5">
            <?= $form
                ->field($model, 'department_id')
                ->widget(\kartik\select2\Select2::class, [
                    'data' => \common\models\DepartmentMenu::getDepartmentOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать департамент...',
                        'multiple' => false,
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
        <div class="col-md-12">
            <?= $form->field($model, 'landing_page_type')->dropDownList($model->getStatusTitles(), [
                'id' => 'landing-page-type', 'prompt' => 'Выберите тип...', 'disabled' => !empty($model->is_all_products),
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'landing_page_id')->dropDownList(\common\components\helpers\DepartmentHelper::getLandingPageOptions($model->landing_page_id), [
                'id' => 'landing-page-id', 'prompt' => 'Выберите страницу...', 'disabled' => empty($model->landing_page_type) || $model->landing_page_type === $model::LANDING_PAGE_TYPE_CATALOG,
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'landing_page_catalog')->dropDownList(\common\components\helpers\DepartmentHelper::getLandingPageCatalogOptions(), [
                'id' => 'landing-page-catalog', 'prompt' => 'Выберите раздел каталога...', 'disabled' => empty($model->landing_page_type) || $model->landing_page_type === $model::LANDING_PAGE_TYPE_PAGE,
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'sort')->input('number', ['disabled' => !empty($model->is_all_products),]) ?>
        </div>
        <div class="col-md-4" style="padding-top:27px;">
            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,], 'options' => ['disabled' => $isLandingMenu,],]) ?>
        </div>
        <div class="col-md-4" style="padding-top:27px;">
            <?= $form->field($model, 'is_all_products')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
        <? if ($isAjax): ?>
            &nbsp; <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> Добавить тематику', ['/department/department-menu/create-tag', 'id' => $model->id,], ['class' => 'btn btn-primary department-tree-create-btn',]) ?>
        <? endif; ?>
    </div>

    <? if (!$model->isNewRecord && !$isAjax): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Тематики</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['create-tag', 'id' => $model->id,], ['class' => 'btn btn-info btn-xs pull-right',]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered',],
                    'rowOptions'=>function(\common\models\DepartmentMenuTag $model){
                        return ['class' => $model->getSpecialClass(),];
                    },
                    'columns' => [
                        'id',
                        'url',
                        'name',
                        'is_active:boolean',
                        [
                            'attribute' => 'updated_at',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return \Yii::$app->formatter->asDatetime($model->updated_at);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update}",
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['/department/department-menu/update-tag', 'id' => $model->id,],
                                        [
                                            'title' => 'Редактировать',
                                            'data-pjax' => false,
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    <? endif; ?>
    <?php ActiveForm::end(); ?>
</div>
