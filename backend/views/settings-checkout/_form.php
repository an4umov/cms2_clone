<?php

use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckout */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo Dialog::widget(['overrideYiiConfirm' => true,]);
?>
<div class="department-model-form">
    <?php $form = ActiveForm::begin(); ?>

    <? if ($model->isNewRecord): ?>
        <?= $form
            ->field($model, 'reference_partner_id')
            ->widget(\kartik\select2\Select2::class, [
                'data' => $model->getReferencePartnerOptions(),
                'options' => [
                    'placeholder' => 'Выбрать партнера...',
                    'multiple' => false,
                    'id' => 'reference_partner_id',
                ],
                'pluginOptions' => [
                    'allowClear' => false,
                ],
                'hideSearch' => true,
            ]);
        ?>
    <? else: ?>
        <?= $form->field($model, 'reference_partner_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label"><?= $model->getAttributeLabel('id') ?></label>
            <div class="col-sm-10"><?= $model->id ?></div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label"><?= $model->getAttributeLabel('reference_partner_id') ?></label>
            <div class="col-sm-10"><?= $model->referencePartner->name ?></div>
        </div>
    <? endif; ?>

    <?= $form->field($model, 'is_default')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
    <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Признак "<?= $model->getAttributeLabel('is_default') ?>" может быть только у одной записи</small>

    <div class="form-group" style="margin-top: 30px;">
        <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
    </div>

    <? if (!$model->isNewRecord): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-11"><h3 class="panel-title">Настройки покупателей</h3></div>
                    <div class="col-lg-1">
                        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span>', ['create-buyer', 'id' => $model->id,], ['class' => 'btn btn-info btn-xs pull-right',]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered',],
                    'rowOptions' => function(\common\models\SettingsCheckoutBuyer $model){
                        return ['class' => $model->getActiveClass(),];
                    },
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'reference_buyer_id',
                            'format' => 'html',
                            'value' => function (\common\models\SettingsCheckoutBuyer $model) {
                                return $model->referenceBuyer->name;
                            },
                        ],
                        [
                            'header' => 'Группы доставки',
                            'format' => 'raw',
                            'value' => function (\common\models\SettingsCheckoutBuyer $model) {
                                return $model->getDeliveryGroupCount();
                            },
                        ],
                        'is_active:boolean',
                        [
                            'attribute' => 'updated_at',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return \Yii::$app->formatter->asDatetime($model->updated_at);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => "{update} {delete}",
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                        ['/settings-checkout/update-buyer', 'id' => $model->id,],
                                        [
                                            'title' => 'Редактировать',
                                            'data-pjax' => false,
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model, $key) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['/settings-checkout/delete-buyer', 'id' => $model->id,],
                                        [
                                            'title' => 'Удалить',
                                            'aria-label' => 'Удалить',
                                            'data' => ['pjax' => false, 'confirm' => 'Вы уверены, что хотите удалить этот элемент?',  'method' => 'post',],
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    <? endif; ?>
    <?php ActiveForm::end(); ?>
</div>
