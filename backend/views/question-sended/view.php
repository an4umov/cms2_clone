<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\QuestionSended */

$this->title = 'Просмотр вопроса от "'.$model->name.'" #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SENDED_QUESTION;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_QUESTIONS);
\yii\web\YiiAsset::register($this);
?>
<div class="question-sended-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'comment',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
        ],
    ]) ?>

</div>
