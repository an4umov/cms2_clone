<?php

use backend\components\widgets\ImageGalleryWidget;
use common\components\helpers\ContentHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentModel */
/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel common\models\search\DepartmentModelListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderMenu yii\data\ActiveDataProvider */
/* @var $isAjax boolean */
?>
<? if ($isAjax): ?><h4><?= $this->title ?></h4><hr/><? endif; ?>
<div class="department-model-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::hiddenInput('is_tree', (int)$isAjax) ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id')->textInput(['maxlength' => 5, 'disabled' => true,]) ?>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-4">
            <?= $form->field($model, 'url')->textInput(['maxlength' => 25,]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'landing_page_id')->dropDownList(\common\components\helpers\DepartmentHelper::getLandingPageOptions($model->landing_page_id), [
                $model->landing_page_id => ['selected' => true,], 'prompt' => 'Выберите страницу...',
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'word_1')->textInput(['maxlength' => 50,]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'word_2')->textInput(['maxlength' => 50,]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'default_title')->textInput(['maxlength' => 50,]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-3">
            <?= $form->field($model, 'sort')->input('number') ?>
        </div>
        <div class="col-md-3" style="padding-top:27px;">
            <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
        <? if ($isAjax): ?>
            &nbsp; <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> Добавить меню', ['/department/department-menu/create', 'id' => $model->id,], ['class' => 'btn btn-primary department-tree-create-btn',]) ?>
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
                            return Html::tag('strong', $menuModel->departmentModel->department->url.'/ ', ['class' => 'text-danger',]).$menuModel->url.(!empty($model->landing_menu_id) && $model->landing_menu_id === $menuModel->id ? ' <i class="fas fa-star-of-life" title="Посадочная страница"></i>' : '');
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
                                    ['/department/department-menu/update', 'id' => $model->id, 'did' => $model->departmentModel->department_id,],
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
