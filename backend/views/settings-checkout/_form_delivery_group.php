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
/* @var $deliveryGroupModel \common\models\ReferenceDeliveryGroup */

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="delivery-group-model-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= \kartik\select2\Select2::widget([
        'name' => 'dgid',
        'value' => $deliveryGroupModel ? $deliveryGroupModel->id : null,
        'data' => $model->getReferenceDeliveryGroupOptions(),
        'options' => ['multiple' => false, 'placeholder' => 'Выбрать группу отправки...'],
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
                    <div class="col-lg-11"><h3 class="panel-title">Способы доставки</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['create-delivery', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id,], ['class' => 'btn btn-success btn-xs pull-right',]) ?>
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
                            'attribute' => 'paymentGroupCount',
                            'header' => 'Количество групп оплаты',
                            'format' => 'raw',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update} {delete}",
                            'buttons' => [
                                'update' => function ($url, $rowModel, $key) use($model, $deliveryGroupModel) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['/settings-checkout/update-delivery', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $rowModel['id'],],
                                        [
                                            'title' => 'Редактировать',
                                            'data-pjax' => false,
                                        ]
                                    );
                                },
                                'delete' => function ($url, $rowModel, $key) use($model, $deliveryGroupModel) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['/settings-checkout/delete-delivery', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $rowModel['id'],],
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