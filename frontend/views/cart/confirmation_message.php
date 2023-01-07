<?php
/**
 * @var \yii\web\View $this
 * @var $activeAction string
 * @var $cartSettings array
 * @var $message string
 */

$this->title = $cartSettings['name'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['activeAction'] = $activeAction;

use \common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\ShopOrder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\helpers\CartHelper;
?>

<!-- Cart-confirmation -->
<section class="cart-confirmation">
     <!-- success message about order -->
     <div class="cart-confirmation-succes-order">
        <div class="cart-confirmation-succes-order__title">
            ваш заказ успешно сформирован!
        </div>
        <div class="cart-confirmation-succes-order__inner">
            <div class="cart-confirmation-succes-order__image">
                <img src="/img/cart/cart-confirmation__success-order.svg" alt="">
            </div>
            <div class="cart-confirmation-succes-order__wrapper">
                <div class="cart-confirmation-succes-order__info">
                    Письмо с содержимым заказа отправлено Вам на почту <br><br>
                    Ожидайте звонка менеджера
                </div>
                <a href='/' class="cart-confirmation-succes-order__btn"> Вернуться на Главную</a>
            </div>
        </div>
    </div>
</section>
