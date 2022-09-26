<?php

use common\models\ReferenceDeliveryGroup;
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
/* @var $deliveryGroupModel common\models\ReferenceDeliveryGroup */
/* @var $deliveryModel common\models\ReferenceDelivery */
/* @var $paymentGroupModel common\models\ReferencePaymentGroup */

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="delivery-group-model-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= Html::hiddenInput('dgid', $deliveryGroupModel->id) ?>
    <?= Html::hiddenInput('did', $deliveryModel->id) ?>

    <?= \kartik\select2\Select2::widget([
        'name' => 'pgid',
        'value' => $paymentGroupModel ? $paymentGroupModel->id : null,
        'data' => $model->getReferencePaymentGroupOptions(),
        'options' => ['multiple' => false, 'placeholder' => 'Выбрать группу оплаты...'],
        'pluginOptions' => [
            'allowClear' => false,
        ],
        'hideSearch' => true,
    ]); ?>

    <div class="form-group" style="margin-top: 30px;">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <? if (!is_null($dataProvider)): ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Способы оплаты</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['create-payment', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $deliveryModel->id, 'pgid' => $paymentGroupModel->id,], ['class' => 'btn btn-success btn-xs pull-right',]) ?>
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
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update} {delete}",
                            'buttons' => [
                                'update' => function ($url, $rowModel, $key) use ($model, $deliveryGroupModel, $deliveryModel, $paymentGroupModel) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['/settings-checkout/update-payment', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $deliveryModel->id, 'pgid' => $paymentGroupModel->id, 'pid' => $rowModel['id'],],
                                        [
                                            'title' => 'Редактировать',
                                            'data-pjax' => false,
                                        ]
                                    );
                                },
                                'delete' => function ($url, $rowModel, $key) use ($model, $deliveryGroupModel, $deliveryModel, $paymentGroupModel) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['/settings-checkout/delete-payment', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $deliveryModel->id, 'pgid' => $paymentGroupModel->id, 'pid' => $rowModel['id'],],
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