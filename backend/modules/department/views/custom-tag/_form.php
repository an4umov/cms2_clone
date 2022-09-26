<?php

use common\models\ContentCustomTag;
use kartik\checkbox\CheckboxX;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomTag */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$newContent = new \common\models\Content();
?>

<div class="department-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50,]) ?>

    <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <? if (!$model->isNewRecord): ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Контент, где используется</h3>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered',],
                    'columns' => [
                        [
                            'header' => $newContent->getAttributeLabel('id'),
                            'format' => 'raw',
                            'value' => function (\common\models\ContentCustomTag $model) {
                                return $model->content_id;
                            },
                        ],
                        [
                            'header' => $newContent->getAttributeLabel('type'),
                            'format' => 'raw',
                            'value' => function (\common\models\ContentCustomTag $model) {
                                return $model->content->getTypeTitle($model->content->type);
                            },
                        ],
                        [
                            'header' => $newContent->getAttributeLabel('name'),
                            'format' => 'raw',
                            'value' => function (\common\models\ContentCustomTag $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span> '.$model->content->name, ['/content/'.$model->content->getTypeToTypesTitle($model->content->type).'/update', 'id' => $model->content_id,]);
                            },
                        ],
                        [
                            'header' => $newContent->getAttributeLabel('alias'),
                            'format' => 'raw',
                            'value' => function (\common\models\ContentCustomTag $model) {
                                return $model->content->alias;
                            },
                        ],
                        [
                            'header' => $newContent->getAttributeLabel('deleted_at'),
                            'format' => 'raw',
                            'value' => function (\common\models\ContentCustomTag $model) {
                                return !empty($model->content->deleted_at) ? '<span class="badge bg-important">Да</span>' : '<span class="badge bg-success">Нет</span>';
                            },
                            'contentOptions' => ['style' => 'text-align:center;',],
                            'headerOptions' => ['style' => 'text-align:center;width:1%;',],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    <? endif; ?>

    <?php ActiveForm::end(); ?>
</div>