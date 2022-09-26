<?php

use backend\components\helpers\IconHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\ParserProverkacheka */

$this->title = 'Просмотр чека с ИНН ' . $model->inn;
$this->params['breadcrumbs'][] = ['label' => 'Справочники', 'url' => ['/references',],];
$this->params['breadcrumbs'][] = ['label' => 'Проверка чека', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PROVERKACHEKA);
?>
<div class="articles-view">
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'inn',
            'total',
            'type',
            [
                'attribute' => 'number',
                'format' => 'html',
                'value' => function (common\models\ParserProverkacheka $model) {
                    return \yii\helpers\Html::img('/img/files/Parsing/proverkacheka.com/'.$model->number.'.svg');
                },
            ],
        ],
    ]) ?>

</div>
