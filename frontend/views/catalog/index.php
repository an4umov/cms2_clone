<?php

/**
 * @var \yii\web\View $this
 * @var string $title
 */

$this->title = $title;

//$this->params['breadcrumbs'][] = ['label' => ' Раздел 1', 'url' => ['post-category/view', 'id' => 10], 'template' => "<li> / </li>\n <li>{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

echo \frontend\components\widgets\CatalogTreeWidget::widget();