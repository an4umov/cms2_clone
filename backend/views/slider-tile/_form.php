<?php

use common\models\ContentItem;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SliderTile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-tile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $model->items = $model->contentItems;
    $cItems = common\models\ContentItem::find()->select(['id', 'title'])->where(['type' => common\models\ContentItem::TYPE_FOR_SLIDER_TILE])->all();

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
