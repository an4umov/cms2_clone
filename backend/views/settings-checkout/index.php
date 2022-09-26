<?php

use kartik\dialog\Dialog;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SettingsCheckoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CHECKOUT;

$widgetID = 'dialog-'.time();

echo Html::style('#'.$widgetID.' div.modal-dialog {width: 50%;}');
echo Html::style('#'.$widgetID.' div.bootstrap-dialog-message {height: 500px; overflow-y: auto;}');

echo Dialog::widget([
    'id' => $widgetID,
    'libName' => 'krajeeDialogSettingsCheckoutView',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Дерево настроек',
        'nl2br' => false,
        'buttons' => [
            [
                'id' => 'cust-cancel-btn',
                'label' => 'Отмена',
                'cssClass' => 'btn-outline-secondary',
                'hotkey' => 'C',
                'action' => new JsExpression("function(dialog) {
                    return dialog.close();
                }")
            ],
            [
                'id' => 'cust-submit-btn',
                'label' => 'ОК',
                'cssClass' => 'btn-success',
                'hotkey' => 'S',
                'action' => new JsExpression("function(dialog) {
                    return dialog.close();
                }")
            ],
        ],
    ],
]);
?>
<div class="settings-checkout-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить настройки для партнера', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function(\common\models\SettingsCheckout $model){
            return ['class' => $model->getDefaultClass(),];
        },
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            [
                'attribute' => 'reference_partner_id',
                'format' => 'raw',
                'value' => function (\common\models\SettingsCheckout $model) {
                    return Html::a($model->referencePartner->name, ['/references/partner/update', 'id' => $model->reference_partner_id,]);
                },
            ],
            [
                'header' => 'Покупатели',
                'format' => 'raw',
                'value' => function (\common\models\SettingsCheckout $model) {
                    return '<span class="badge bg-inverse">'.$model->getSettingsCheckoutBuyersCount().'</span>';
                },
            ],
            'is_default:boolean',
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} &nbsp; {update} &nbsp; {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return \yii\helpers\Html::a('<i class="fas fa-sitemap"></i>',
                            '#', [
                                'data-id' => $model->id,
                                'title' => 'Дерево',
                                'aria-label' => 'Дерево',
                                'class' => 'settings-checkout-view-btn'
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
