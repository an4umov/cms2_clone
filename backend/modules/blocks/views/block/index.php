<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\models\Block;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type string */

$this->title = $searchModel->getTypeTitle($searchModel->blockType);

$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS,],];
if (!in_array($type, [Block::TYPE_AGGREGATOR,])) {
    $this->params['breadcrumbs'][] = ['label' => 'Обычные блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON,],];
}
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
if (empty($this->params['secondMenu'])) {
    $this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_COMMON;
}
$this->params['thirdMenu'] = $searchModel->blockType;

$this->params['menuIcon'] = IconHelper::getSpanIcon($searchModel->getTypeIcon($searchModel->blockType));

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="block-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить', ['create'], ['class' => 'btn btn-success',]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'header' => 'Используется',
                'format' => 'raw',
                'value' => function (\common\models\Block $model) {
                    return '<span class="badge bg-info">'.$model->getUsedCount().'</span>';
                },
            ],
            [
                'header' => 'Полей',
                'format' => 'raw',
                'value' => function (\common\models\Block $model) {
                    return '<span class="badge bg-inverse">'.$model->getBlockFieldsCount().'</span>';
                },
            ],
            [
                'attribute' => 'deleted_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->deleted_at) ? '<span class="badge bg-important">Да</span>' : '<span class="badge bg-success">Нет</span>';
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
                'visibleButtons' => [
                    'update' =>  function (\common\models\Block $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                    'delete' =>  function (\common\models\Block $model, $key, $index) {
                        return empty($model->deleted_at);
                    },
                ],
                'template' => "{update} {delete}",
            ],
        ],
    ]); ?>
</div>
