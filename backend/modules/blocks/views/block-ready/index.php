<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\BlockReadySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->getTypeTitle($searchModel->blockType);

$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/blocks',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_BLOCK_READY;

$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_READY);

echo Dialog::widget(['overrideYiiConfirm' => true,]);
$js = "jQuery('[data-toggle=\"popover\"]').popover({html:true});";
$this->registerJs($js, $this::POS_READY);

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
                'attribute' => 'global_type',
                'format' => 'raw',
                'value' => function (\common\models\BlockReady $model) {
                    return '<strong>'.$model->getGlobalTypeTitle($model->global_type).'</strong>';
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'global_type',
                    'data' => $searchModel->getFilterGlobalTypeOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать ...',
                        'multiple' => false,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            [
                'header' => 'Используется',
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;',],
                'value' => function (\common\models\BlockReady $model) {
                    $data = [];
                    $newModel = new \common\models\Content();
                    $contents = $model->getContents()->asArray()->all();
                    foreach ($contents as $index => $content) {
                        $name = \common\components\helpers\AppHelper::truncate($content['name'], 25);
                        $data[] = ++$index." <a target='_blank' href='"."/content/".$content['type']."/".$content['id']."'>[".mb_substr($newModel->getTypeTitle($content['type']), 0, 1)."] ".$name."</a>";

                        if ($index > 9) {
                            break;
                        }
                    }
                    $btnClass = $data ? 'primary' : 'secondary';

                    return '<button title="Список контента" type="button" class="btn btn-'.$btnClass.'" data-container="body" data-toggle="popover" data-placement="top" data-content="'.implode('<br>', $data).'">'.count($data).'</button>';
//                    return '<span class="badge bg-info">'.$model->getUsedCount().'</span>';
                },
            ],
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->is_active) ? '<span class="badge bg-success">Да</span>' : '<span class="badge bg-important">Нет</span>';
                },
                'contentOptions' => ['style' => 'text-align:center;',],
                'headerOptions' => ['style' => 'text-align:center;',],
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
                    'delete' =>  function (\common\models\BlockReady $model, $key, $index) {
                        return $model->is_active;
                    },
                ],
                'template' => "{update} {delete}",
            ],
        ],
    ]); ?>
</div>
