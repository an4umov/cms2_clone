<?php

/**
 * @var \yii\web\View $this
 * @var string $number
 * @var array $data
 */

use \yii\helpers\Html;
use \common\components\helpers\CatalogHelper;

$this->title = 'Артикул #'.$number;
?>

<?= \frontend\components\widgets\ProductOffersWidget::widget(['title' => 'ТОВАРЫ', 'numbers' => ['ALR1165', '1013938', '11H1781L',],]) ?>