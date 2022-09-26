<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GreenMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Зеленое меню';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = ['label' => $this->title,];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_GREEN_MENU;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_GREEN_MENU);
?>
<div class="green-menu-index">
    <p><?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered',],
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'landing_page_id',
                'format' => 'raw',
                'value' => function (\common\models\GreenMenu $model) {
                    $pageModel = $model->landingPage;

                    return $pageModel ? Html::a(IconHelper::getSpanIcon(IconHelper::ICON_LINK).' '.$pageModel->name, ['/content/pages/update', 'id' => $model->landing_page_id,], ['blank' => '_target',]) : '';
                },
            ],
            'sort',
            [
                'attribute' => 'is_enabled',
                'format' => 'raw',
                'value' => function (\common\models\GreenMenu $model) {
                    return $model->is_enabled ? '<span class="badge bg-success">Да</span>' : 'Нет';
                },
            ],
            [
                'attribute' => 'is_department_menu',
                'format' => 'raw',
                'value' => function (\common\models\GreenMenu $model) {
                    return $model->is_department_menu ? '<span class="badge bg-success">Да</span>' : 'Нет';
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at, "medium");
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}",
            ],
        ],
    ]); ?>
</div>
