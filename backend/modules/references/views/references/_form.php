<?php
use backend\components\widgets\ImageGalleryWidget;
use common\components\helpers\ContentHelper;
use kartik\checkbox\CheckboxX;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\References */
/* @var $form yii\widgets\ActiveForm */

$className = $model::className();
$names = explode('\\', $className);
$name = end($names);
?>
<div class="references-form">
    <? $form = ActiveForm::begin(); ?>
    <? if ($model instanceof \common\models\ReferencePartner): ?>
        <?= $form->field($model, 'name')->dropDownList(\common\components\helpers\ReferenceHelper::getFullPricePartners(), ['prompt' => 'Выбрать...',]) ?>
    <? else: ?>
        <?= $form->field($model, 'name')->textInput() ?>
    <? endif; ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'is_active')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,],]);  ?>
    <div class="form-group">
    <?= ImageGalleryWidget::widget([
        'initdir' => ContentHelper::getImagesLogoPath(),
        'dir' => ContentHelper::getImagesLogoPath(),
        'filename' => $model->icon ? substr($model->icon, strrpos($model->icon, DIRECTORY_SEPARATOR) + 1) : '',
        'filepath' => $model->icon ?: '',
        'name' => $name.'[icon]',
    ]); ?>
    </div>

    <div class="form-group">
        <?= \common\components\helpers\AppHelper::getSubmitButtons() ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
