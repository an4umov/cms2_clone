<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $message array */
/* @var $inn string */
/* @var $kpp string */
/* @var $name string */
/* @var $type string */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'DaData Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mycontainer ">
    <div class="pills-user-tab">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="row">
            <div class="col-12 col-sm-12 d-flex flex-wrap ">
                <div class="col-lg-4 ">
                    <label class="tabs-label">ИНН <input type="text" placeholder="Введите ИНН" name="inn" value="<?= $inn ?>"></label>
                    <label class="tabs-label">КПП <input type="text" placeholder="Введите КПП" name="kpp" value="<?= $kpp ?>"></label>
    <!--                <label class="tabs-label">НАИМЕНОВАННИЕ <input type="text" name="name" placeholder="Введите Наименование" value="--><?//= $name ?><!--"></label>-->
                    <label class="tabs-label">Тип <?= Html::dropDownList('type', $type, ['' => 'Все', 'legal' => 'Юрлица', 'individual' => 'Индивидуальные предприниматели',]) ?></label>
                </div>
                <div class="col-lg-4 ">
                    <?php echo Html::submitButton('ИСКАТЬ', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <? if ($message): ?>
        <div class="panel panel-primary" style="margin-top: 30px;">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-12"><h4 class="panel-title">Результат</h4></div>
                </div>
            </div>
            <div class="panel-body">
                <? if (is_array($message)): ?>
                    <pre><? print_r($message) ?></pre>
                <? elseif (is_string($message)): ?>
                    <?= $message; ?>
                <? else: ?>
                    <? var_dump($message); ?>
                <? endif; ?>
            </div>
        </div>
        <? endif; ?>
    </div>
</div>
