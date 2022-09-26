<?php

use common\components\helpers\AppHelper;
use \common\components\helpers\CatalogHelper;
use \frontend\components\widgets\ContentWidget;
use frontend\components\widgets\DepartmentMenuWidget;

/**
 * @var \yii\web\View $this
 * @var \common\models\Content $model
 * @var string $shop
 */

$this->title = $model->title ? $model->title : $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->getManyTypeTitle($model->type), 'url' => '/'.$model->getTypeToTypesTitle($model->type), 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,];

$this->params[AppHelper::TEMPLATE_KEY_SHOP_MENU] = $model->alias;

if ($shop) {
    $this->params[AppHelper::TEMPLATE_KEY_SHOP] = $shop;
}

$JS = <<<JS
jQuery('.panel-collapse').on('show.bs.collapse', function () {
    jQuery(this).siblings('.panel-heading').addClass('active');
});

jQuery('.panel-collapse').on('hide.bs.collapse', function () {
    jQuery(this).siblings('.panel-heading').removeClass('active');
});
JS;

//$this->registerJs($JS, \yii\web\View::POS_READY);

echo ContentWidget::widget(['model' => $model, 'shop' => $shop, 'isPage' => true,]);