<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\components\helpers\CatalogHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ShopOrder */

$this->title = 'Просмотр заказа #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_ADMIN_TRASH;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_TRASH);
\yii\web\YiiAsset::register($this);

$attributes = [
    'id',
    [
        'attribute' => 'user_id',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return $model->getUserName() ;
        },
    ],
    //            'coupon_id',
    //            'coupon_cost',
    //            'event_id',
    //            'event_cost',
    //            'discount',
    //            'discount_cost',
    [
        'attribute' => 'total',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return CatalogHelper::formatPrice($model->total);
        },
    ],
    [
        'attribute' => 'total_cost',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return CatalogHelper::formatPrice($model->total_cost);
        },
    ],
    'is_need_installation:boolean',
    'cargo_weight',
    'cargo_length',
    'cargo_height',
    'cargo_width',
    'cargo_volume',
    'email:email',
    'phone',
    'name',
    [
        'attribute' => 'user_type',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return $model->getUserTypeTitle($model->user_type) ;
        },
    ],
    //            'settings_delivery_id',
    //            'delivery_comment:ntext',
    //            'settings_payment_id',
    //            'payment_comment:ntext',
];

if ($model->user_type === \common\models\ShopOrder::USER_TYPE_LEGAL_PERSON) {
    $attributes[] = [
        'attribute' => 'legal_type',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return $model->getLegalTypeTitle($model->legal_type) ;
        },
    ];
    $attributes[] = 'legal_inn';
    $attributes[] = 'legal_kpp';
    if ($model->legal_type === \common\models\ShopOrder::LEGAL_TYPE_COMPANY) {
        $attributes[] = 'legal_organization_name';
    }
    $attributes[] = 'legal_address:ntext';

    $attributes[] =     [
        'attribute' => 'legal_payment',
        'format' => 'raw',
        'value' => function (\common\models\ShopOrder $model) {
            return $model->getLegalPaymentTitle($model->legal_payment) ;
        },
    ];

    $attributes[] = 'legal_bik';
    $attributes[] = 'legal_bank';
    $attributes[] = 'legal_correspondent_account';
    $attributes[] = 'legal_payment_account';
    $attributes[] = 'legal_comment:ntext';
}

$attributes[] = 'comment:ntext';
$attributes[] = [
    'attribute' => 'created_at',
    'format' => 'raw',
    'value' => function ($model) {
        return \Yii::$app->formatter->asDatetime($model->created_at);
    },
];


?>
<div class="shop-order-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
