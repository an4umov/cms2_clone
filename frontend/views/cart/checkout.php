<?php

/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var $model \common\models\Order
 */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/cart',], 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use common\components\helpers\AppHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$isEmpty = empty($cartItems = $cart->getItems());
?>
<div class="container mycontainer">
<?php if(!$isEmpty): ?>
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'enableClientValidation' => false,]); ?>

    <table class="table">
        <thead>
        <tr class="active">
            <th>Наименование</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
            <th><i aria-hidden="true">&times;</i></th>
        </tr>
        </thead>
        <tbody>
    <?php foreach($cartItems as $item): ?>
        <tr>
            <td><a href="<?= Url::to(['shop/code', 'code' => $item->getProduct()->product_code,])?>"><?= $item->getProduct()->article_number ?></a></td>
            <td><?= $item->getQuantity() ?></td>
            <td><?= $item->getPrice() ?></td>
            <td><?= $item->getCost() ?></td>
            <td><a href="<?= Url::to(['cart/remove', 'id' => $item->getId()]) ?>">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo $form->field($model, 'comment')->textarea(['rows' => 3,]) ?>
    <div class="form-group">
        <?php echo Html::submitButton('Подтвердить заказ', ['class' => 'btn btn-success',]) ?>
        <?php echo Html::submitButton('Отменить заказ', ['class' => 'btn btn-success', 'name' => AppHelper::BTN_CANCEL,]) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php else:?>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        Корзина пуста
    </div>
<?php endif;?>
</div>
