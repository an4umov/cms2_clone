<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FormSended */

$this->title = 'Просмотр отправки формы #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Админ', 'url' => ['/'.MenuHelper::FIRST_MENU_ADMIN,],];
$this->params['breadcrumbs'][] = ['label' => 'Формы', 'url' => ['/'.MenuHelper::SECOND_MENU_SENDED_QUESTION,],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_ADMIN;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SENDED_FORM;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_FORM);
\yii\web\YiiAsset::register($this);
?>
<div class="form-sended-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'form_id',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    $form = $model->getForm()->one();

                    return $form ? Html::a($form->name, ['/form/form/update', 'id' => $model->form_id,]) : null;
                },
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
                'attribute' => 'data',
                'format' => 'raw',
                'value' => function (\common\models\FormSended $model) {
                    return '<pre>'.print_r($model->getData(), true).'</pre>';
                },
            ],
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
