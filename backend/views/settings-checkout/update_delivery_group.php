<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckoutBuyer */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $deliveryGroupModel \common\models\ReferenceDeliveryGroup */

$this->title = 'Изменить группу отправки "'.$deliveryGroupModel->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings',],];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => 'Партнер "'.$model->settingsCheckout->referencePartner->name.'"', 'url' => ['settings-checkout/update', 'id' => $model->settings_checkout_id,],];
$this->params['breadcrumbs'][] = ['label' => 'Покупатель "'.$model->referenceBuyer->name.'"', 'url' => ['settings-checkout/update-buyer', 'id' => $model->id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CHECKOUT;
?>
<div class="settings-checkout-update">
    <?= $this->render('_form_delivery_group', [
        'model' => $model,
        'deliveryGroupModel' => $deliveryGroupModel,
        'dataProvider' => $dataProvider,
    ]) ?>
</div>
