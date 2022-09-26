<?php

use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckoutBuyer */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ArrayDataProvider */

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="department-model-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form
        ->field($model, 'reference_buyer_id')
        ->widget(\kartik\select2\Select2::class, [
            'data' => $model->getReferenceBuyerOptions(),
            'options' => [
                'placeholder' => 'Выбрать покупателя...',
                'multiple' => false,
                'id' => 'reference_buyer_id',
            ],
            'pluginOptions' => [
                'allowClear' => false,
            ],
            'hideSearch' => true,
        ]);
    ?>

    <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>


    <div class="form-group" style="margin-top: 30px;">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <? if (!$model->isNewRecord): ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Группы способов доставки</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['create-delivery-group', 'id' => $model->id,], ['class' => 'btn btn-success btn-xs pull-right',]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered',],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'header' => 'ID',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'name',
                            'header' => 'Название',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'deliveryCount',
                            'header' => 'Количество способов доставки',
                            'format' => 'raw',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update} {delete}",
                            'buttons' => [
                                'update' => function ($url, $dataModel, $key) use ($model) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['/settings-checkout/update-delivery-group', 'id' => $model->id, 'dgid' => $dataModel['id'],],
                                        [
                                            'title' => 'Редактировать',
                                            'data-pjax' => false,
                                        ]
                                    );
                                },
                                'delete' => function ($url, $dataModel, $key) use ($model) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['/settings-checkout/delete-delivery-group', 'id' => $model->id, 'dgid' => $dataModel['id'],],
                                        [
                                            'title' => 'Удалить',
                                            'aria-label' => 'Удалить',
                                            'data' => ['pjax' => false, 'confirm' => 'Вы уверены, что хотите удалить этот элемент?',  'method' => 'post',],
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