<?php

/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var \common\models\Order $model
 */

$this->title = 'Оплата заказа';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use \common\components\helpers\CartHelper;
use YandexCheckout\Client;
use yii\helpers\Url;

$isEmpty = empty($cartItems = $cart->getItems());

if (!$isEmpty) {
    $client = new Client();
    $client->setAuth(CartHelper::YA_KASSA_TEST_SHOP_ID, CartHelper::YA_KASSA_TEST_SECRET_KEY);
    $cost = 0;
    foreach ($cartItems as $cartItem) {
        $cost += $cartItem->getCost();
    }

    $payment = $client->createPayment(
        [
            'amount' => [
                'value' => $cost,
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'embedded',
            ],
            'capture' => true,
            'description' => 'Заказ №'.$model->id,
            'metadata' => [
                'order_id' => $model->id,
            ],
        ],
        uniqid('', true)
    );

    $this->registerJsFile('https://kassa.yandex.ru/checkout-ui/v2.js', ['position' => $this::POS_HEAD,]);

    $js = '
    const checkout = new window.YandexCheckout({
        confirmation_token: "'.$payment->getConfirmation()->getConfirmationToken().'",
        return_url: "'.Url::toRoute('/checkout/order-received/'.$model->id, true).'",
        error_callback(error) {
            alert("Ошибка");
            console.log(error);
        }
    });

    checkout.render("payment-form");';

    $this->registerJs($js, $this::POS_END);
}
?>
<div class="container mycontainer">
    <pre><?//= $js //var_dump($payment) ?></pre>
<?php if(!$isEmpty): ?>
    <div class="table-responsive">
        <div id="payment-form"></div>
    </div>
<?php else:?>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        Корзина пуста
    </div>
<?php endif;?>
</div>
