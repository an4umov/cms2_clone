<?php

/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var $item \devanych\cart\CartItem
 */

$this->title = 'Успешный возврат средств';
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/cart',], 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use yii\helpers\Url;
$isEmpty = empty($cartItems = $cart->getItems());
?>
<div class="container mycontainer">
<?php if(!$isEmpty): ?>
<?php else:?>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        Корзина пуста
    </div>
<?php endif;?>
</div>
