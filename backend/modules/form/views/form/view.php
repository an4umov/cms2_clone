<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \common\models\Form */
/* @var $searchModel common\models\search\FormSendedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Информация по отправке формы "'.$model->name.'"';

$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS,],];
$this->params['breadcrumbs'][] = ['label' => 'Формы', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_FORMS;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FORM);

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="form-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    return $model->user_id ? 'Пользователь' : null;
                },
            ],
            'page',
            'emails',
            [
                'attribute' => 'data',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    $text = '';
                    $data = $model->getData();
                    foreach ($data as $key => $value) {
                        $text .= '<b>'.$key.'</b>: '.\common\components\helpers\AppHelper::truncate($value, 100).'<br>';
                    }

                    return $text;
                },
                'headerOptions' => ['style' => 'width:33%;',],
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at, "medium");
                },
            ],
        ],
    ]); ?>
</div>
