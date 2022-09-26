<?php

use \backend\components\helpers\MenuHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \common\components\helpers\ParserHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsItems */

$formID = 'form-lrparts-items-add';
$imageSrc = ParserHelper::getLrPartsDefaultImageUrl();
$imageInfo = ParserHelper::getLrPartsImageInfo($imageSrc);
?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => $formID,
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/parsing/lrparts/add-item?rid='.$model->rubric_id,]),
                'options' => ['class' => 'form-horizontal', 'name' => 'form_lrparts_items',],
            ]); ?>
            <?= $form->field($model, 'rubric_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
            <div class="form-group">
                <label class=control-label"><?= $model->getAttributeLabel('is_active')?></label>
                <?= \kartik\checkbox\CheckboxX::widget([
                    'name' => 'ParserLrpartsItems[is_active]',
                    'value' => $model->is_active,
                    'options' => ['class' => 'form-control', 'id' => 'parserlrpartsitems-is_active-'.time()],
                    'pluginOptions' => ['threeState' => false,],
                ])  ?>
            </div>

            <?= $form->field($model, 'position')->textInput(['maxlength' => 255,]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
            <?= $form->field($model, 'code')->textInput(['maxlength' => 25,]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>

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