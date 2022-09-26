<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\components\helpers\CatalogHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShopOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Корзина';

$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_ADMIN_TRASH;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_TRASH);
?>
<div class="shop-order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function (\common\models\ShopOrder $model) {
                    return $model->getUserName() ;
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
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
            ],
        ],
    ]); ?>
</div>
