<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\helpers\MenuHelper;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $footerModel common\models\SettingsFooter */

$title = 'Пункты';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_FOOTER;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FOOTER);
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-11"><h3 class="panel-title"><?= $title ?></h3></div>
            <div class="col-lg-1">
                <?= Html::a('<i class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></i>', ['/settings-footer-item/create', 'footer_id' => $footerModel->id,], ['class' => 'btn btn-info btn-xs pull-right',]) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="settings-footer-item-index">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'url:url',
                    'is_active:boolean',
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
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return \yii\helpers\Html::a('<i class="fa fa-eye"></i>',
                                    ['/settings-footer-item/view', 'id' => $model->id,], [
                                        'title' => 'Просмотр',
                                        'aria-label' => 'Просмотр',
                                    ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                    ['/settings-footer-item/update', 'id' => $model->id,],
                                    [
                                        'title' => 'Редактировать',
                                        'data-pjax' => false,
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>