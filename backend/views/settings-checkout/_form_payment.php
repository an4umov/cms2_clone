<?php

use common\models\ReferenceDeliveryGroup;
use kartik\checkbox\CheckboxX;
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
/* @var $paymentModel common\models\ReferencePayment */
?>
<div class="delivery-group-model-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= Html::hiddenInput('dgid', $deliveryGroupModel->id) ?>
    <?= Html::hiddenInput('did', $deliveryModel->id) ?>
    <?= Html::hiddenInput('pgid', $paymentGroupModel->id) ?>

    <?= \kartik\select2\Select2::widget([
        'name' => 'pid',
        'value' => $paymentModel ? $paymentModel->id : null,
        'data' => $model->getReferencePaymentOptions(),
        'options' => ['multiple' => false, 'placeholder' => 'Выбрать способ оплаты...'],
        'pluginOptions' => [
            'allowClear' => false,
        ],
        'hideSearch' => true,
    ]); ?>

    <div class="form-group" style="margin-top: 30px;">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>