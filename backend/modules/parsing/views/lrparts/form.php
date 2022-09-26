<?php

use backend\components\helpers\IconHelper;
use \yii\helpers\Html;
use \backend\components\helpers\MenuHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsItems */
/* @var $form yii\widgets\ActiveForm */

$formID = 'form-lrparts-item';
?>

<div class="item-form">
    <?php $form = ActiveForm::begin([
        'id' => $formID,
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'method' => 'post',
        'action' => Url::to(['/parsing/lrparts/update',]),
    ]); ?>
    <?= $form->field($model, 'id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
    <div class="form-group">
        <label class="control-label" for="parserlrpartsitems-name"><?= $model->getAttributeLabel('is_active')?></label>
        <?= \kartik\checkbox\CheckboxX::widget([
            'name' => 'ParserLrpartsItems[is_active]',
            'value' => $model->is_active,
            'options' => ['class' => 'form-control', 'id' => 'parserlrpartsitems-is_active'],
            'pluginOptions' => ['threeState' => false,],
        ])  ?>

        <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'rubric_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'position')->textInput(['maxlength' => 255,]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => 25,]) ?>
    <div>
        <b><?= $model->getAttributeLabel('url') ?>:</b> <a href="<?= \Yii::$app->params['frontendUrl'].'/search/'.$model->code ?>" target="_blank"><?= IconHelper::getSpanIcon(IconHelper::ICON_LINK).' '. \Yii::$app->params['frontendUrl'].'/epc/search/'.$model->code ?></a>
    </div>
    <div style="margin-top: 10px;">
        <b><?= $model->getAttributeLabel('path') ?>:</b> <a href="<?= 'https://lrparts.ru'.$model->path ?>" target="_blank"><?= IconHelper::getSpanIcon(IconHelper::ICON_LINK).' '.'https://lrparts.ru'.$model->path ?></a>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    var itemListUrl = '<?= '/'.MenuHelper::FIRST_MENU_PARSING.'/'.MenuHelper::SECOND_MENU_PARSING_LRPARTS.'/view?id='.$model->rubric_id ?>';
    var itemForm = jQuery("#<?= $formID ?>");
    itemForm.validate({
        rules: {
            "ParserLrpartsItems[position]": "required",
            "ParserLrpartsItems[name]": "required",
            "ParserLrpartsItems[code]": "required"
        },
        messages: {
            "ParserLrpartsItems[position]": "Заполните поле",
            "ParserLrpartsItems[name]": "Заполните поле",
            "ParserLrpartsItems[code]": "Заполните поле"
        }
    });
</script>