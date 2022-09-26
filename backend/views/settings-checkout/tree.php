<?php

use \common\components\helpers\ReferenceHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckout */

$partnerName = $model->referencePartner->name;
?>

<div>
    <div class="panel panel-default">
        <div class="panel-heading">Настройки партнера "<?= $partnerName ?>"</div>
        <div class="panel-body">
            <!-- TREEVIEW CODE -->
            <div class="treeview">
                <ul>
                    <li><a href="/settings-checkout/update?id=<?= $model->id ?>" target="_blank"><?= $partnerName ?></a>
                        <ul>
                        <? foreach ($model->settingsCheckoutBuyers as $checkoutBuyer): ?>
                            <? $json = $checkoutBuyer->getData(); ?>
                            <li><a href="/settings-checkout/update-buyer?id=<?= $checkoutBuyer->id ?>" target="_blank"><?= $checkoutBuyer->referenceBuyer->name ?></a>
                            <? if (!empty($json[ReferenceHelper::BUYER_DELIVERY_GROUP])): ?>
                                <ul>
                                <? foreach ($json[ReferenceHelper::BUYER_DELIVERY_GROUP] as $deliveryGroupID => $deliveryList): ?>
                                <? $deliveryGroupModel = \common\models\ReferenceDeliveryGroup::findOne($deliveryGroupID) ?>
                                    <li><a href="/settings-checkout/update-delivery-group?id=<?= $checkoutBuyer->id ?>&dgid=<?= $deliveryGroupID ?>" target="_blank"><?= $deliveryGroupModel ? $deliveryGroupModel->name : '[Не найдена группа доставки: '.$deliveryGroupID.']' ?></a>
                                    <? if (!empty($json[ReferenceHelper::BUYER_DELIVERY_GROUP][$deliveryGroupID][ReferenceHelper::BUYER_DELIVERY])): ?>
                                        <ul>
                                        <? foreach ($json[ReferenceHelper::BUYER_DELIVERY_GROUP][$deliveryGroupID][ReferenceHelper::BUYER_DELIVERY] as $deliveryID => $paymentGroupList): ?>
                                        <? $deliveryModel = \common\models\ReferenceDelivery::findOne($deliveryID) ?>
                                            <li><a href="/settings-checkout/update-delivery?id=<?= $checkoutBuyer->id ?>&dgid=<?= $deliveryGroupID ?>&did=<?= $deliveryID ?>" target="_blank"><?= $deliveryModel ? $deliveryModel->name : '[Не найдена доставка: '.$deliveryID.']' ?></a>
                                            <? if (!empty($json[ReferenceHelper::BUYER_DELIVERY_GROUP][$deliveryGroupID][ReferenceHelper::BUYER_DELIVERY][$deliveryID][ReferenceHelper::BUYER_PAYMENT_GROUP])): ?>
                                                <ul>
                                                <? foreach ($json[ReferenceHelper::BUYER_DELIVERY_GROUP][$deliveryGroupID][ReferenceHelper::BUYER_DELIVERY][$deliveryID][ReferenceHelper::BUYER_PAYMENT_GROUP] as $paymentGroupID => $paymentIDs): ?>
                                                <? $paymentGroupModel = \common\models\ReferencePaymentGroup::findOne($paymentGroupID) ?>
                                                    <li><a href="/settings-checkout/update-payment-group?id=<?= $checkoutBuyer->id ?>&dgid=<?= $deliveryGroupID ?>&did=<?= $deliveryID ?>&pgid=<?= $paymentGroupID ?>" target="_blank"><?= $paymentGroupModel ? $paymentGroupModel->name : '[Не найдена группа платежа: '.$paymentGroupID.']' ?></a>
                                                        <? if (!empty($paymentIDs)): ?>
                                                        <ul>
                                                        <? foreach ($paymentIDs as $paymentID): ?>
                                                        <? $paymentModel = \common\models\ReferencePayment::findOne($paymentID) ?>
                                                            <li><a href="/settings-checkout/update-payment?id=<?= $checkoutBuyer->id ?>&dgid=<?= $deliveryGroupID ?>&did=<?= $deliveryID ?>&pgid=<?= $paymentGroupID ?>&pid=<?= $paymentID ?>" target="_blank"><?= $paymentModel ? $paymentModel->name : '[Не найден платеж: '.$paymentID.']' ?></a></li>
                                                        <? endforeach; ?>
                                                        </ul>
                                                        <? endif; ?>
                                                    </li>
                                                <? endforeach; ?>
                                                </ul>
                                            <? endif; ?>
                                            </li>
                                        <? endforeach; ?>
                                        </ul>
                                    <? endif; ?>
                                    </li>
                                <? endforeach; ?>
                                </ul>
                            <? endif; ?>
                            </li>
                        <? endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- TREEVIEW CODE -->
        </div>
    </div>
</div>
<style>
    div.panel:first-child {
        margin-top:20px;
    }

    div.treeview {
        min-width: 100px;
        min-height: 100px;
        overflow:auto;
        padding: 4px;
        margin-bottom: 20px;
        color: #369;
        border: solid 1px;
        border-radius: 4px;
    }
    div.treeview ul:first-child:before {
        display: none;
    }
    .treeview, .treeview ul {
        margin:0;
        padding:0;
        list-style:none;
        color: #369;
    }
    .treeview ul {
        margin-left:1em;
        position:relative
    }
    .treeview ul ul {
        margin-left:.5em
    }
    .treeview ul:before {
        content:"";
        display:block;
        width:0;
        position:absolute;
        top:0;
        left:0;
        border-left:1px solid;
        /* creates a more theme-ready standard for the bootstrap themes */
        bottom:15px;
    }
    .treeview li {
        margin:0;
        padding:0 1em;
        line-height:2em;
        font-weight:700;
        position:relative
    }
    .treeview ul li:before {
        content:"";
        display:block;
        width:10px;
        height:0;
        border-top:1px solid;
        margin-top:-1px;
        position:absolute;
        top:1em;
        left:0
    }
    .tree-indicator {
        margin-right:5px;
        cursor:pointer;
    }
    .treeview li a {
        text-decoration: none;
        color:inherit;
        cursor:pointer;
    }
    .treeview li button, .treeview li button:active, .treeview li button:focus {
        text-decoration: none;
        color:inherit;
        border:none;
        background:transparent;
        margin:0 0 0 0;
        padding:0 0 0 0;
        outline: 0;
    }
</style>