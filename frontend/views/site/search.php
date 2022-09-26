<?php

use \frontend\components\widgets\ProductOffersWidget;
use \frontend\components\widgets\ErrorWidget;
use yii\helpers\Html;

/* @var \yii\web\View $this
 * @var \frontend\models\search\SiteSearch $searchModel
 * @var string $shop
 * @var array $params
 * @var array $errors
 * @var \yii\data\Pagination $pages
 * @var \yii\data\ActiveDataProvider $dataProvider
*/

$this->title = 'Результат поиска';
$this->params['searchModel'] = $searchModel;
if ($shop) {
    $this->params['shop'] = $shop;
}
$params[ProductOffersWidget::PARAM_TITLE] = $this->title;
//$params[ProductOffersWidget::PARAM_NUMBERS] = ['ALR1165', '1013938', '11H1781L',];

if (!empty($errors)) {
    foreach ($errors as $error) {
        $text['text'] = array_shift($error);
        //echo \yii\helpers\Html::tag('p', \yii\helpers\Html::tag('strong', 'Ошибка: ').$text, ['class' => 'text-error',]).PHP_EOL;
    }
    
    echo ErrorWidget::widget($text);
} else {
    echo ProductOffersWidget::widget($params);
}
?>
