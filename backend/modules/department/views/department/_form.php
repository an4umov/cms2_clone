<?php

use backend\components\widgets\ImageGalleryWidget;
use common\components\helpers\ContentHelper;
use kartik\checkbox\CheckboxX;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $isAjax boolean */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProviderMenu yii\data\ActiveDataProvider */
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-form">
    <?php $form = ActiveForm::begin(['id' => 'department-form', 'enableClientValidation' => true,]); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax)  ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id')->textInput(['maxlength' => 5, 'disabled' => true,]) ?>
        </div>
        <div class="col-md-10">
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
            <?= $form->field($model, 'default_menu_id')->dropDownList($model->isNewRecord ? [] : \common\components\helpers\DepartmentHelper::getDefaultMenuOptions($model->id), [
                $model->default_menu_id => ['selected' => true,], 'prompt' => 'Выберите пункт меню...',
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
            <?= $form->field($model, 'catalog_code')->input('text') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sort')->input('number') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="padding-top:27px;">
            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
        </div>
<!--        <div class="col-md-6" style="padding-top:27px;">-->
            <?//= $form->field($model, 'is_default')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,], 'options' => ['disabled' => $model->getIsDefaultState(),],]);  ?>
<!--        </div>-->
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
        <? if ($isAjax): ?>
            &nbsp; <?= Html::a('<span class="'.IconHelper::ICON_ADD.'"></span> Добавить меню', ['/department/department-menu/create', 'id' => $model->id,], ['class' => 'btn btn-primary department-tree-create-btn',]) ?>
        <? endif; ?>
    </div>

    <? if (!$model->isNewRecord && !$isAjax): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Меню</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['/department/department-menu/create', 'id' => $model->id,], ['class' => 'btn btn-info btn-xs pull-right',]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderMenu,
                    'rowOptions'=>function(\common\models\DepartmentMenu $model){
                        return ['class' => $model->getSpecialClass(),];
                    },
                    'tableOptions' => ['class' => 'table table-bordered',],
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'url',
                            'format' => 'raw',
                            'value' => function (\common\models\DepartmentMenu $menuModel) use ($model) {
                                return Html::tag('strong', $menuModel->department->url.'/ ', ['class' => 'text-danger',]).$menuModel->url.(!empty($model->landing_menu_id) && $model->landing_menu_id === $menuModel->id ? ' <i class="fas fa-star-of-life" title="Посадочная страница"></i>' : '');
                            },
                        ],
                        'name',
                        [
                            'attribute' => 'icon',
                            'format' => 'html',
                            'value' => function (\common\models\DepartmentMenu $model) {
                                return !empty($model->icon) ? '<i class="'.$model->icon.'"></i>' : null;
                            },
                        ],
                        'is_active:boolean',
                        'is_special:boolean',
                        [
                            'header' => 'Тематик',
                            'format' => 'raw',
                            'value' => function (\common\models\DepartmentMenu $model) {
                                return '<span class="badge bg-success">'.$model->getTagCount().'</span>';
                            },
                        ],
                        'sort',
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
                                        ['/department/department-menu/update', 'id' => $model->id, 'did' => $model->department_id,],
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