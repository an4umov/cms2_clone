<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */
/* @var $form yii\widgets\ActiveForm */
/* @var $staticTemplates array */
?>

<div class="template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php
    $aliasField = $form->field($model, 'alias');
    $aliasField->enableClientValidation = false;
    echo $aliasField->textInput(['maxlength' => true]);
    ?>

    <?php echo $form->field($model, 'content')->textarea() ?>

    <?php echo $form->field($model, 'active')->checkbox() ?>

    <?php echo $form->field($model, 'type')->dropDownList(\backend\models\Template::getTypes(), [
            'id' => 'template_type',
            $model->type => [
                    'checked' => true
            ]
    ]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJsVar('staticTemplates', \yii\helpers\Json::encode($staticTemplates));

$JS = <<<JS
/* global staticTemplates */
$('#template_type').on('change', function () {
        if (typeof staticTemplates === "undefined") {
            return false;
        }
        
        let val = $(this).val();
        if (val === "" || typeof val === "undefined") {
            return false;
        }
        let staticTemplatesObject = JSON.parse(staticTemplates);
        if (typeof staticTemplatesObject[val] === "undefined") {
            return false;
        }
        $('#template-content').val(staticTemplatesObject[val]);
        //$.Redactor.prototype.code().set(staticTemplatesObject[val]);
    });
JS;

$this->registerJs($JS);

Modal::begin([
    'toggleButton' => ['label' => 'Подсказка', 'class' => 'btn btn-default'],
]);
?>

<ol>
    <li>
        Для вставки своего контента в виджет в редакторе следует в нужных местах
        вставлять конструкцию вида {%key|Название поля%},
        где key служит для определения поля в системе, "Название поля" - для заголовка поля ввода при заполнении в редакторе
    </li>
    <li>
        Левая часть (key) может состоять из букв, цифр и знаков подчеркивания _.
        Правая часть может состоять из букв, цифр, знаков подчерквания и пробелов.
    </li>
</ol>

<?php
Modal::end();


?>