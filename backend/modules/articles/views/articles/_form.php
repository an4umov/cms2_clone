<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\old\Articles */
/* @var $form yii\widgets\ActiveForm */

$tags = \yii\helpers\ArrayHelper::map(\backend\models\old\Tags::find()->all(), 'name', 'name');

?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput() ?>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'announce')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'announce_image')->textarea(['rows' => 6]) ?>
    <?php echo $form->field($model, 'image')->fileInput() ?>

    <?php echo $form->field($model, 'url_key')->textInput() ?>

    <?php echo $form->field($model, 'deleted')->dropDownList([0 => 'Нет', 1 => 'Да']) ?>

    <?php echo $form->field($model, 'create_time')->textInput(['value' => Yii::$app->formatter->asDatetime(time(), 'Y-MM-d H:i:s')]) ?>

    <?php echo $form->field($model, 'last_change')->textInput(['value' => Yii::$app->formatter->asDatetime(time(), 'Y-MM-d H:i:s')]) ?>

    <?php echo $form->field($model, 'show_on_the_main')->dropDownList([0 => 'Нет', 1 => 'Да']) ?>

    <?php echo $form->field($model, 'pageTitle')->textarea(['rows' => 6]) ?>

    <?php

    echo $form->field($model, 'articleTags')->widget(\kartik\select2\Select2::classname(), [
        'data' => $tags,
        'options' => [
            'placeholder' => 'Выберите теги',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]);
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
