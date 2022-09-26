<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form \backend\models\form\LrPartsRubricBlockForm */
/* @var $block common\models\Block */
/* @var $activeForm yii\widgets\ActiveForm */
/* @var $action string */
/* @var $blocks array */

$formID = 'form-content-block-'.$action;

$varBlocks = [];
foreach ($blocks as $type => $list) {
    $varBlocks[$type] = [];
    foreach ($list as $id => $name) {
        $varBlocks[$type][] = ['id' => $id, 'name' => $name,];
    }
}
$this->registerJs(
    "var blocks = ".\yii\helpers\Json::htmlEncode($varBlocks).";",
    View::POS_END,
    'blocks'
);
?>

<div class="block-form">
    <? if ($form->rubric_id): ?>
        <?php $activeForm = ActiveForm::begin([
            'id' => $formID,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/parsing/lrparts/block-'.$action,]),
        ]); ?>
        <?= $activeForm->field($form, 'rubric_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <?= $activeForm->field($form, 'type')->dropDownList(\common\components\helpers\BlockHelper::getAddBlockOptions($blocks, true), ['prompt' => 'Выбрать...',]) ?>
        <?= $activeForm->field($form, 'block_id')->dropDownList([], ['prompt' => 'Выбрать...', 'id' => 'form-lrparts-block-container',]) ?>
        <?php ActiveForm::end(); ?>
    <? else: ?>
        <div class="alert alert-block alert-danger fade in">
            <strong>Ошибка!</strong> Отсутствует обязательный параметр
        </div>
    <? endif; ?>
</div>
<script>
    var blockAddForm = jQuery("#<?= $formID ?>");
    blockAddForm.validate({
        rules: {
            "LrPartsRubricBlockForm[type]": "required",
            "LrPartsRubricBlockForm[block_id]": "required"
        },
        messages: {
            "LrPartsRubricBlockForm[type]": "Выберите тип",
            "LrPartsRubricBlockForm[block_id]": "Выберите блок"
        }
    });
</script>