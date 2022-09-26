<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LkMailing */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/settings/index',],];
$this->params['breadcrumbs'][] = ['label' => 'Почтовые рассылки', 'url' => ['/settings/mailing',]];
$this->params['breadcrumbs'][] = ['label' => $this->title,];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MAILING;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING);
?>
<div class="lk-mailing-view">
    <p>
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id,], ['class' => 'btn btn-primary',]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'sort',
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
