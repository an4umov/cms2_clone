<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\form\ContentBlockForm */
/* @var $block common\models\Block */
/* @var $form yii\widgets\ActiveForm */
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
    <? if ($model->content_id): ?>
        <?php $form = ActiveForm::begin([
            'id' => $formID,
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/content/block/'.$action,]),
        ]); ?>
        <?= $form->field($model, 'content_id', ['options' => ['tag' => null,],])->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'type')->dropDownList(\common\components\helpers\BlockHelper::getAddBlockOptions($blocks), ['prompt' => 'Выбрать...',]) ?>
        <?= $form->field($model, 'block_id')->dropDownList([], ['prompt' => 'Выбрать...', 'id' => 'form-content-block-container',]) ?>
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
            "ContentBlockForm[type]": "required",
            "ContentBlockForm[block_id]": "required"
        },
        messages: {
            "ContentBlockForm[type]": "Выберите тип",
            "ContentBlockForm[block_id]": "Выберите блок"
        }
    });
</script>