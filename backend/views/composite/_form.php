<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Composite */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="composite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(\common\models\Composite::getTypes(), [
        $model->type => ['selected' => true],
        'prompt' => ''
    ]) ?>

    <?php

    $cItems = common\models\ContentItem::find()->select(['id', 'title'])->all();
    $model->items = $model->contentItems;

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
    ]);?>

    <?php echo $form->field($model,'images_list')->widget(FileInput::class,[
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'initialPreview'=> $model->imagesList(),
            'initialPreviewAsData'=>true,
            'initialCaption'=>"Выберите изображение",
            'initialPreviewConfig' => [],
            'overwriteInitial'=>false,
            'maxFileSize'=>2800,
            'deleteUrl' => Url::to(['file/delete-image','id'=>$model->id]),
        ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
