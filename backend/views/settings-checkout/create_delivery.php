<?php

use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckoutBuyer */
/* @var $deliveryGroupModel common\models\ReferenceDeliveryGroup */

$this->title = 'Добавить способ доставки';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings',],];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Партнер "'.$model->settingsCheckout->referencePartner->name.'"', 'url' => ['settings-checkout/update', 'id' => $model->settings_checkout_id,],];
$this->params['breadcrumbs'][] = ['label' => 'Покупатель "'.$model->referenceBuyer->name.'"', 'url' => ['settings-checkout/update-buyer', 'id' => $model->id,],];
$this->params['breadcrumbs'][] = ['label' => 'Группа доставки "'.$deliveryGroupModel->name.'"', 'url' => ['settings-checkout/update-delivery-group', 'id' => $model->id, 'dgid' => $deliveryGroupModel->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CHECKOUT;
?>
<div class="settings-checkout-create">
    <?= $this->render('_form_delivery', [
        'model' => $model,
        'deliveryGroupModel' => $deliveryGroupModel,
        'deliveryModel' => null,
        'dataProvider' => null,
    ]) ?>
</div>
