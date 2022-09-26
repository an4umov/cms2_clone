<?php

use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsCheckoutBuyer */
/* @var $form yii\widgets\ActiveForm */
/* @var $referenceDeliveryGroupSelect string */
/* @var $referenceDeliverySelect string */
/* @var $referencePaymentGroupSelect string */
/* @var $referencePaymentSelect string */


$js = "
jQuery('#settings-checkout-form').stepy({
  backLabel: 'Предыдущий шаг',
  block: true,
  nextLabel: 'Следующий шаг',
  titleClick: true,
  titleTarget: '.stepy-tab'
});

jQuery('#".\common\models\ReferenceDeliveryGroup::tableName()."').multiSelect();
jQuery('#".\common\models\ReferenceDelivery::tableName()."').multiSelect();
jQuery('#".\common\models\ReferencePaymentGroup::tableName()."').multiSelect();
jQuery('#".\common\models\ReferencePayment::tableName()."').multiSelect();

jQuery('#reference_buyer_id').change();
";
$this->registerJs($js, $this::POS_READY);
?>
<section class="panel">
    <div class="panel-body" style="width: 80%;margin: 0 auto;">
        <div class="stepy-tab">
            <ul id="default-titles" class="stepy-titles clearfix">
                <li id="default-title-0" class="">
                    <div>Тип покупателя</div>
                </li>
                <li id="default-title-1" class="">
                    <div>Группы доставки</div>
                </li>
                <li id="default-title-2" class="">
                    <div>Способы доставки</div>
                </li>
                <li id="default-title-3" class="">
                    <div>Группы оплаты</div>
                </li>
                <li id="default-title-4" class="">
                    <div>Способы оплаты</div>
                </li>
            </ul>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => '', 'id' => 'settings-checkout-form',],]); ?>
            <fieldset title="Шаг 1" class="step" id="default-step-0" >
                <legend> </legend>

                <div class="form-group">
                    <label class="control-label col-md-3">Тип покупателя</label>
                    <div class="col-md-9">
                        <?= $form
                            ->field($model, 'reference_buyer_id')
                            ->widget(\kartik\select2\Select2::class, [
                                'data' => $model->getReferenceBuyerOptions(),
                                'options' => [
                                    'placeholder' => 'Выбрать покупателя...',
                                    'multiple' => false,
                                    'id' => 'reference_buyer_id',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => false,
                                ],
                                'hideSearch' => true,
                            ]);
                        ?>
                    </div>
                </div>
            </fieldset>
            <fieldset title="Шаг 2" class="step" id="default-step-1" >
                <legend> </legend>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Группы доставки</label>
                    <div class="col-lg-9">
                        <?= $referenceDeliveryGroupSelect ?>
                    </div>
                </div>
            </fieldset>
            <fieldset title="Шаг 3" class="step" id="default-step-2" >
                <legend> </legend>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Способы доставки</label>
                    <div class="col-lg-9">
                        <?= $referenceDeliverySelect ?>
                    </div>
                </div>
            </fieldset>
            <fieldset title="Шаг 4" class="step" id="default-step-3" >
                <legend> </legend>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Группы оплаты</label>
                    <div class="col-lg-9">
                        <?= $referencePaymentGroupSelect ?>
                    </div>
                </div>
            </fieldset>
            <fieldset title="Шаг 5" class="step" id="default-step-4" >
                <legend> </legend>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Способы оплаты</label>
                    <div class="col-lg-9">
                        <?= $referencePaymentSelect ?>
                    </div>
                </div>
            </fieldset>

            <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'finish btn btn-danger', 'id' => 'settings-checkout-submit',]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>