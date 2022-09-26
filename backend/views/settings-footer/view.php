<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\helpers\MenuHelper;
use backend\components\helpers\IconHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsFooter */

$this->title = 'Блок: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => '/settings',];
$this->params['breadcrumbs'][] = ['label' => 'Футер', 'url' => ['index'],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_FOOTER;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FOOTER);
?>
<div class="settings-footer-view">
    <p><?php echo Html::a('Редактировать', ['update', 'id' => $model->id,], ['class' => 'btn btn-primary',]) ?></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
