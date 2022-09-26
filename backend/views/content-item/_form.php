<?php

use common\models\ContentItem;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContentItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $type integer */
//VarDumper::dump($type, 3, 1);exit;
?>

<?php if ( Yii::$app->session->hasFlash(ContentItem::ERROR_INVALID_RATIO) ): ?>
    <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash(ContentItem::ERROR_INVALID_RATIO); ?>
    </div>
<?php endif;?>

<div class="content-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'fa_icon')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(ContentItem::types(), [
        'options' => [
            $type => ['selected' => true]
        ]
    ]) ?>

    <?= $form->field($model, 'sort')->input('number') ?>

    <?php echo $form->field($model,'uploadImage')->widget(FileInput::class,[
        'options'=>[
            'multiple'=>false
        ],
        'pluginOptions' => [
            'initialPreview'=> $model->imagesList(),
            'initialPreviewAsData'=>true,
            'initialCaption'=>"Выберите изображение",
            'initialPreviewConfig' => [],
            'overwriteInitial'=>false,
            'maxFileSize'=>2800,
            'deleteUrl' => Url::to(['content-item/delete-image','id'=>$model->id]),
        ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
