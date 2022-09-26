<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\detail\DetailView;
use zxbodya\yii2\tinymce\TinyMce;
use common\models\CartSettings;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <?php echo DetailView::widget([
                'model' => $model,
                'mode' => DetailView::MODE_VIEW,
                'striped' => false,
                'buttons1' => empty($model->deleted_at) ? '{delete}' : '',
                'panel' => [
                    'type' => DetailView::TYPE_SUCCESS,
                    'heading' => IconHelper::getSpanIcon($model->getTypeIcon($model->type)).' Просмотр контента',
                ],
                'deleteOptions'=>[ // your ajax delete parameters
                    'params' => ['id' => $model->id,],
                    'url' => '/content/'.$model->getTypeToTypesTitle($model->type).'/delete',
                    'confirm' => 'Вы уверены, что хотите удалить этот контент?',
                    'ajaxSettings' => ['method' => 'POST', 'type' => 'POST', 'async' => false,],
                ],
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'displayOnly' => true,
                        'labelColOptions' => ['style' => 'width:30%;text-align: right;',],
                    ],
                    [
                        'attribute' => 'type',
                        'displayOnly' => true,
                        'format' => 'raw',
                        'value' => Html::tag('strong', $model->getTypeTitle($model->type)),
                    ],
                    'name',
                    [
                        'attribute' => 'alias',
                        'label' => 'Урл для сайта',
                        'format' => 'raw',
                        'value' => Html::tag('span', '/'.$model->getTypeToTypesTitle($model->type).'/', ['class' => 'text-primary',]).($model->alias ?: $model->id),
                        'displayOnly' => true,
                    ],
                    [
                        'label' => 'Посмотреть на сайте',
                        'attribute' => 'alias',
                        'format' => 'raw',
                        'value' => '<a href="'.Yii::$app->params['frontendUrl'].$model->getContentUrl().'" class="external-page-link" target="_blank" title="Посмотреть на сайте"><i class="fas fa-external-link-square-alt"></i></a>',
                    ],
                    'views',
                    [
                        'label' => 'Блоков',
                        'attribute' => 'alias',
                        'format' => 'raw',
                        'value' => '<span class="badge bg-inverse">'.$model->getAllBlocksCount().'</span>',
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'raw',
                        'value' => \Yii::$app->formatter->asDatetime($model->updated_at),
                    ],
                    [
                        'attribute' => 'deleted_at',
                        'format' => 'raw',
                        'value' => !empty($model->deleted_at) ? '<span class="badge bg-important">Да</span>' : '<span class="badge bg-success">Нет</span>',
                    ],
                    [
                        'label' => 'Редактировать',
                        'attribute' => 'alias',
                        'format' => 'raw',
                        'value' => Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_EDIT.'"></span> '.'Редактировать', ['/content/'.$model->getTypeToTypesTitle($model->type).'/update', 'id' => $model->id,], ['class' => 'btn btn-info', 'target' => '_blank',]),
                    ],
                ],
            ]) ?>
        </div>
    </div>
</section>