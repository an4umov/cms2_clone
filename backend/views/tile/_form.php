<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php

    $cItems = \common\models\ContentItem::find()->where(['type' => \common\models\ContentItem::TYPE_FOR_TILE])->select(['id', 'title'])->all();
    $model->items = $model->contentItems;

    echo $form->field($model, 'items')->widget(\kartik\select2\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map($cItems, 'id', 'title'),
        'options' => [
            'placeholder' => 'Выберите контент',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
