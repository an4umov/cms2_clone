<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestionSendedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы';
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SENDED_QUESTION;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_QUESTIONS);
?>
<div class="question-sended-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user_id',
            [
                'attribute' => 'content_id',
                'format' => 'raw',
                'value' => function (\common\models\QuestionSended $model) {
                    $content = $model->getContent();
                    return $content ? Html::a($content->name, ['/content/'.$model->content_type.'/update', 'id' => $model->content_id,]) : null;
                },
            ],
            'name',
            'email:email',
            [
                'attribute' => 'comment',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:30%;',],
                'value' => function (\common\models\QuestionSended $model) {
                    return \common\components\helpers\AppHelper::truncateWords($model->comment, 30);
                },
            ],
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
