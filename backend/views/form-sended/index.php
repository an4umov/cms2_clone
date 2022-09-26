<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $formID int */
/* @var $searchModel common\models\search\FormSendedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Формы';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SENDED_FORM;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FORM);
?>
<div class="form-sended-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'form_id',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    $form = $model->getForm()->one();

                    return $form ? Html::a($form->name, ['/form/form/update', 'id' => $model->form_id,]) : null;
                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'form_id',
                    'data' => \common\components\helpers\FormHelper::getFormOptions(),
                    'options' => [
                        'placeholder' => 'Выбрать форму...',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                ]),
            ],
            'user_id',
            [
                'attribute' => 'page',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    return Html::a($model->page, $model->page, ['target' => '_blank',]);
                },
            ],
            'emails:email',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
            ],
        ],
    ]); ?>
</div>
