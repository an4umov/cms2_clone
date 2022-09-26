<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\helpers\MenuHelper;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsFooterItem */

$this->title = 'Пункт блока: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => '/settings',];
$this->params['breadcrumbs'][] = ['label' => 'Футер', 'url' => '/settings-footer',];
$this->params['breadcrumbs'][] = ['label' => 'Блок', 'url' => ['/settings-footer/update', 'id' => $model->footer_id,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_FOOTER;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FOOTER);
?>
<div class="settings-footer-item-view">
    <p><?php echo Html::a('Редактировать', ['update', 'id' => $model->id,], ['class' => 'btn btn-primary',]) ?></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'footer_id',
                'format' => 'raw',
                'value' => function (common\models\SettingsFooterItem $model) {
                    return Html::a($model->footer->name, ['/settings-footer/update', 'id' => $model->footer_id,]);
                },
            ],
            'name',
            'url:url',
            'is_active:boolean',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at, "medium");
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->updated_at, "medium");
                },
            ],
        ],
    ]) ?>
</div>
