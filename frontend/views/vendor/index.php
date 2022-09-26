<?php

/**
 * @var \yii\web\View $this
 * @var array $data
 */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use yii\helpers\Url;
?>

<h1><?= $this->title ?></h1>

<pre><? print_r($data) ?></pre>