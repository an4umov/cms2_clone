<?php

/**
 * @var \yii\web\View $this
 * @var array $params
 * @var \common\models\Catalog $model
 */

use frontend\components\widgets\ProductOffersWidget;

if ($params) {
    echo ProductOffersWidget::widget($params);
} else {
    echo \yii\helpers\Html::tag('p', 'Ничего не найдено....');
}
