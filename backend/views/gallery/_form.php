<?php

use common\models\ContentItem;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
/* @var $filesPath string */

// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation
use yii\helpers\Url;
use \kartik\file\FileInput;

?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'options')->textInput() ?>
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
            'deleteUrl' => Url::to(['gallery/delete-image','id'=>$model->id]),
        ]
    ])?>

    <?php

    $cItems = common\models\ContentItem::find()->select(['id', 'title'])->where(['type' => ContentItem::TYPE_FOR_GALLERY])->all();

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

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php if (! $model->isNewRecord) : ?>
<div class="row">
    <p>Для отображения слайдера в контенте сайта вставьте код [gallery id=<?php echo $model->id ?>] в нужное место материала</p>
</div>
<?php endif ;?>