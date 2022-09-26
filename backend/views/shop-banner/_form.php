<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
use \kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\ShopBanner */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="low-banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'color')->widget(ColorInput::class, [
                'options' => ['placeholder' => 'Выберите цвет ...'],
            ]); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model,'upload_image')->widget(FileInput::class,[
                'options'=>[ 'multiple'=>1 ],
                'pluginOptions' => [
                    'initialPreview'=> $model->background->fullPath ?? '',
                    'initialPreviewAsData'=>true,
                    'initialCaption'=>"Выберите изображение",
                    'initialPreviewConfig' => [],
                    'overwriteInitial'=>false,
                    'maxFileSize'=>2800,
                    'deleteUrl' => \yii\helpers\Url::to(['low-banner/delete-image','id'=>$model->id]),
                ]
            ])?>
        </div>
    </div>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'sort')->input('number') ?>

    <?php echo $form->field($model, 'type')->dropDownList(\common\models\ShopBanner::getTypes(), [
            $model->type => ['selected' => true]
    ]) ?>



    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (! $model->isNewRecord) : ?>
        <p>
            Для отображения в контенте вставьте [shop_banner id=<?php echo $model->id ?>]
        </p>
    <?php endif; ?>
</div>
