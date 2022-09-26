<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckout */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $deliveryGroupModel common\models\ReferenceDeliveryGroup */
/* @var $deliveryModel common\models\ReferenceDelivery */
/* @var $paymentGroupModel common\models\ReferencePaymentGroup */
/* @var $paymentModel common\models\ReferencePayment */

$this->title = 'Изменить способ оплаты "'.$paymentModel->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings',],];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Партнер "'.$model->settingsCheckout->referencePartner->name.'"', 'url' => ['settings-checkout/update', 'id' => $model->settings_checkout_id,],];
$this->params['breadcrumbs'][] = ['label' => 'Покупатель "'.$model->referenceBuyer->name.'"', 'url' => ['settings-checkout/update-buyer', 'id' => $model->id,],];
$this->params['breadcrumbs'][] = ['label' => 'Группа доставки "'.$deliveryGroupModel->name.'"', 'url' => ['settings-checkout/update-delivery-group', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id,],];
$this->params['breadcrumbs'][] = ['label' => 'Доставка "'.$deliveryModel->name.'"', 'url' => ['settings-checkout/update-delivery', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id,  'did' => $deliveryModel->id,],];
$this->params['breadcrumbs'][] = ['label' => 'Группа оплаты "'.$paymentGroupModel->name.'"', 'url' => ['settings-checkout/update-payment-group', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id, 'did' => $deliveryModel->id, 'pgid' => $paymentGroupModel->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CHECKOUT;
?>
<div class="settings-checkout-update">
    <?= $this->render('_form_payment', [
        'model' => $model,
        'deliveryGroupModel' => $deliveryGroupModel,
        'deliveryModel' => $deliveryModel,
        'paymentGroupModel' => $paymentGroupModel,
        'paymentModel' => $paymentModel,
    ]) ?>
</div>
