<?php
/**
 * @var $order ShopOrder
 * @var $items object
 */

use \common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$cartImages = [];
$cart = Yii::$app->cart;
$items = $cart->getItems();
foreach ($items as $item) {
    $product = $item->getProduct();
    // echo "<pre>";
    // print_r($item);
    // exit();
    $cartImages[$item->getId()] = Html::img('/img/'.Catalog::IMAGE_NOT_AVAILABLE_180);

    $images = CatalogHelper::scanCatalogImages($product->article_number);
    if ($images) {
        $image = array_shift($images);

        $cartImages[$item->getId()] = $image;
    }
}
?>
<!-- Cart-confirmation -->
<h1>
	<a href="<?= Url::base(true) ?>" style="text-align: center; display: block;">
		<img src="<?= Url::base(true) ?>/img/logo.png" alt="">
	</a>
</h1>
<table style="max-width: 800px; width: 100%; margin: 20px auto;">
    <? foreach ($items as $key => $item): ?>
    <? $product = $item->getProduct(); ?>
	<tr style="border-bottom: 1px solid #ccc;">
		<td style="padding: 15px; border-bottom: 1px solid #ccc; width: 150px;">
			<img src="<?=Url::base(true).$cartImages[$item->getId()] ?>" alt="" style="width: 100%;">
		</td>
		<td style="padding: 15px; border-bottom: 1px solid #ccc;">
			<p><b><?= $product->article->name ?></b></p>
		</td>
        <td style="width: 80px; border-bottom: 1px solid #ccc; text-align: center;">
            <?= $item->getQuantity().' шт.' ?>
        </td>
		<td style="padding: 15px; color: orange; font-weight: bold; border-bottom: 1px solid #ccc; min-width: 150px;"><?= CatalogHelper::formatPrice($item->getCost()).' р.'; ?></td>
	</tr>
    <? endforeach; ?>
    <tr>
        <td colspan="4" style="text-align: right; font-weight: bold; padding: 30px 15px;">
            Итого с учетом скидок:
            <?= CatalogHelper::formatPrice($order->total_cost).' р.' ?>
        </td>
    </tr>
</table>
<table style="max-width: 800px; width: 100%; margin: 20px auto;">
    <tr valign="top">
        <td>
            <b>Данные покупателя:</b>
            <? if ($order->name): ?>
                <p>
                    Имя:
                    <b><?=$order->name?></b>
                </p>
            <?
                endif;
                if ($order->email):
            ?>
                <p>
                    Почта:
                    <b><?=$order->email?></b>
                </p>
            <?
                endif;
                if ($order->phone):
            ?>
                <p>
                    Телефон:
                    <b><?=$order->phone?></b>
                </p>
            <?
                endif;
                if ($order->getUserTypeTitle($order->user_type)):
            ?>
                <p>
                    Статус покупаля:
                    <b><?= $order->getUserTypeTitle($order->user_type) ?></b>
                </p>
            <? endif; ?>
        </td>
        <td>
            <b>Способ получения:</b>
            <? if ($order->delivery_type_name): ?>
                <p>
                    <b>Тип получения:</b>
                    <?=$order->delivery_type_name;?>
                </p>
            <? endif; ?>
            <? if ($order->delivery_carrier_name): ?>
                <p>
                    <b>Компания перевозчик:</b>
                    <?=$order->delivery_carrier_name;?>
                </p>
            <? endif; ?>
            <?
                if ($order->delivery_city or $order->delivery_index or $order->delivery_address or $order->delivery_apartment) {
                    if ($order->delivery_city) {
                        echo $order->delivery_city;
                    }
                    if ($order->delivery_index) {
                        echo '/ '.$order->delivery_index;
                    }
                    if ($order->delivery_address) {
                        echo '/ '.$order->delivery_address;
                    }
                    if ($order->delivery_apartment) {
                        echo ', '.$order->delivery_apartment;
                    }
                }
            ?> 
        </td>
        <td>
            <b>Способ оплаты:</b>
            <? if ($order->payment_type_name): ?>
                <p>
                    <?=$order->payment_type_name;?>
                </p>
            <? endif; ?>
        </td>
    </tr>
    <tr colspan="3">
        <td>
            <b>Комментарий к заказу:</b>
            <? if ($order->comment): ?>
                <p>
                    <?=$order->comment;?>
                </p>
            <? endif; ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right;">
            Дата формирования заказа: <?= date('d.m.Y H:i:s') ?>
        </td>
    </tr>
</table>