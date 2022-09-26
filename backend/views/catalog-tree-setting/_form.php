<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogTreeSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tile-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'row_count_desktop')->dropDownList($model->getRowCountOptions(), ['style' => 'width:100px;',]) ?>
        <?= $form->field($model, 'row_count_laptop')->dropDownList($model->getRowCountOptions(), ['style' => 'width:100px;',]) ?>
        <?= $form->field($model, 'row_count_mobile')->dropDownList($model->getRowCountOptions(), ['style' => 'width:100px;',]) ?>

        <?= $form->field($model, 'header_font_size')->input('number', ['style' => 'width:100px;',]) ?>
        <?= $form->field($model, 'grid_height')->input('number', ['style' => 'width:100px;',]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success,']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
