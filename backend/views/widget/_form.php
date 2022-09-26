<?php

use common\models\ContentItem;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Widget;

/* @var $this yii\web\View */
/* @var $type mixed */
/* @var $model common\models\Widget */
/* @var $form yii\widgets\ActiveForm */

$modal = "";

switch ($type) {
    case Widget::TYPE_IMAGES_TILE_ONLY_TITLE_1 :
    case Widget::TYPE_IMAGES_TILE_ONLY_TITLE_2 :
    case Widget::TYPE_IMAGES_TILE_LEFT_TEXT :
        $modal = 'images-tile-modal';
        break;

    default :
        $modal = 'images-tile-modal';
}

$_type = $model->type ?? $type;
//\yii\helpers\VarDumper::dump($_type, 3, 1);exit;
?>

<div class="widget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php if ((int)$type === Widget::TYPE_IMAGES_TILE_LEFT_TEXT)  {
        echo $form->field($model, 'text')->textarea(['rows' => 6]);
    } ?>

    <?= $form->field($model, 'type')->dropDownList(Widget::types(), [
        'options' => [
            $_type => [
                'selected' => true
            ],
        ]
    ]) ?>

    <?php
    $model->items = $model->contentItems;
    $cItems = common\models\ContentItem::find()->select(['id', 'title'])->where(['type' => common\models\ContentItem::TYPE_FOR_WIDGET])->all();

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
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php echo $this->render($modal); ?>

    <?php ActiveForm::end(); ?>

</div>
