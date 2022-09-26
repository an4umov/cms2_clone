<?php

use kartik\color\ColorInput;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'color')->widget(ColorInput::class, [
        'options' => ['placeholder' => 'Выберите цвет ...'],
    ]); ?>

    <?php echo $form->field($model,'upload_image')->widget(FileInput::class,[
        'options'=>[ 'multiple'=>1 ],
        'pluginOptions' => [
            'initialPreview'=> $model->background->fullPath ?? '',
            'initialPreviewAsData'=>true,
            'initialCaption'=>"Выберите изображение",
            'initialPreviewConfig' => [],
            'overwriteInitial'=>false,
            'maxFileSize'=>2800,
            'deleteUrl' => \yii\helpers\Url::to(['info-block/delete-image','id'=>$model->id]),
        ]
    ])?>

    <?php echo $form->field($model, 'type')->dropDownList(common\models\InfoBlock::getTypes(), [
        $model->type => ['selected' => true]
    ]) ?>

    <?= $form->field($model, 'sort')->input('number') ?>
    <?= $form->field($model, 'link')->input('text') ?>

    <?php
    $model->items = $model->contentItems;
    $cItems = common\models\ContentItem::find()->select(['id', 'title'])->where(['type' => common\models\ContentItem::TYPE_FOR_INFO_BLOCK])->all();

    echo $form->field($model, 'items')->widget(kartik\select2\Select2::class, [
        'data' => yii\helpers\ArrayHelper::map($cItems, 'id', 'title'),
        'options' => [
            'placeholder' => 'Выберите контент',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
