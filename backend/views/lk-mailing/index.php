<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LkMailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Почтовые рассылки';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_MAILING,],];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MAILING;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING);
?>
<div class="lk-mailing-index">
    <p><?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'name',
            'sort',
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at, "medium");
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {update}",
            ],
        ],
    ]); ?>
</div>
