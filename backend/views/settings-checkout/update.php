<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckout */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Изменить настройки для партнера "'.$model->referencePartner->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings',],];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CHECKOUT;
?>
<div class="settings-checkout-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>
</div>
