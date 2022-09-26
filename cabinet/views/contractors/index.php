<?php

/* @var $this yii\web\View */
/* @var $entities \common\models\UserContractorEntity[] */
/* @var $persons \common\models\UserContractorPerson[] */
/* @var $newPayment \common\models\UserContractorPayment */
/* @var $lkSettings \common\models\LkSettings */

$this->title = 'Контрагенты';
$this->params['breadcrumbs'][] = $this->title;

use \common\models\UserContractorPayment;
use common\components\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <div class="nk-block-des">
            <p>Здесь вы можете управлять контрагентами для своего аккаунта. Типы: юр.лица/ИП или частные лица. <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
        </div>
    </div>
</div>
<div class="nk-block">
    <div class="nk-data data-list">
        <div class="data-head">
            <h6 class="overline-title">
                Юридические лица / ИП
                <a href="#" class="data-head-right" data-toggle="modal" data-target="#contractor-entity-edit-0"><span class="text-primary"><em class="icon ni ni-user-add-fill"></em></span> Добавить</a>
            </h6>
        </div>
    </div><!-- data-list -->
    <div class="nk-block card">
        <table class="table table-ulogs">
            <thead class="thead-light">
            <tr>
                <th class="tb-col-os"><span class="overline-title">Название</span></th>
                <th class="tb-col-time"><span class="overline-title">ИНН</span></th>
                <th class="tb-col-time"><span class="overline-title">КПП</span></th>
                <th class="tb-col-time"><span class="overline-title">По умолчанию</span></th>
                <th class="tb-col-time"><span class="overline-title">Активен</span></th>
                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
            </tr>
            </thead>
            <tbody id="user-contractor-container">
            <? foreach ($entities as $entity): ?>
                <? if (!$entity->isNewRecord): ?>
                <tr>
                    <td class="tb-col-os"><?= $entity->name ?></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->inn ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->kpp ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->is_default ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->is_active ? '<span class="badge badge-pill badge-dim badge-outline-success">Да</span>' : '<span class="badge badge-pill badge-dim badge-outline-danger">Нет</span>' ?></span></td>
                    <td class="tb-col-action">
                        <? if (!$entity->is_default): ?>
                            <?= Html::a('<em class="icon ni ni-trash"></em>', ['/contractors/entity-delete',  'id' => $entity->id], [
                                'class' => 'link-cross mr-sm-n1',
                                'data' => [
                                    'confirm' => 'Действительно удалить юр. лицо?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <? endif; ?>
                        <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#contractor-entity-edit-<?= $entity->id ?>"><em class="icon ni ni-edit"></em></a>
                    </td>
                </tr>
                <? endif ?>
            <? endforeach ?>
            </tbody>
        </table>
    </div><!-- .nk-block-head -->
</div><!-- .nk-block -->
<div class="nk-block">
    <div class="nk-data data-list">
        <div class="data-head">
            <h6 class="overline-title">
                Частные лица
                <a href="#" class="data-head-right" data-toggle="modal" data-target="#contractor-person-edit-0"><span class="text-primary"><em class="icon ni ni-user-add"></em></span> Добавить</a>
            </h6>
        </div>
    </div><!-- data-list -->
    <div class="nk-block card">
        <table class="table table-ulogs">
            <thead class="thead-light">
            <tr>
                <th class="tb-col-os"><span class="overline-title">Имя</span></th>
                <th class="tb-col-time"><span class="overline-title">Фамилия</span></th>
                <th class="tb-col-time"><span class="overline-title">Отчество</span></th>
                <th class="tb-col-time"><span class="overline-title">По умолчанию</span></th>
                <th class="tb-col-time"><span class="overline-title">Активен</span></th>
                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
            </tr>
            </thead>
            <tbody id="user-contractor-container">
            <? foreach ($persons as $person): ?>
                <? if (!$person->isNewRecord): ?>
                <tr>
                    <td class="tb-col-os"><?= $person->firstname ?></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $person->lastname ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $person->secondname ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->is_default ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $entity->is_active ? '<span class="badge badge-pill badge-dim badge-outline-success">Да</span>' : '<span class="badge badge-pill badge-dim badge-outline-danger">Нет</span>' ?></span></td>
                    <td class="tb-col-action">
                        <? if (!$person->is_active): ?>
                            <?= Html::a('<em class="icon ni ni-trash"></em>', ['/contractors/person-delete', 'id' => $person->id], [
                                'class' => 'link-cross mr-sm-n1',
                                'data' => [
                                    'confirm' => 'Действительно удалить частное лицо?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <? endif; ?>
                        <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#contractor-person-edit-<?= $person->id ?>"><em class="icon ni ni-edit"></em></a>
                    </td>
                </tr>
                <? endif ?>
            <? endforeach ?>
            </tbody>
        </table>
    </div><!-- .nk-block-head -->
</div><!-- .nk-block -->

<? foreach ($entities as $entity): ?>
    <!-- @@ contractor Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="contractor-entity-edit-<?= $entity->id ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title"><?= $entity->isNewRecord ? 'Добавить' : 'Изменить' ?> юр. лицо / ИП</h5>
                    <div class="tab-content">
                        <?php $form = ActiveForm::begin([
                            'validationUrl' => ['/contractors/entity-check',],
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => true,
                            'options' => ['class' => 'form-validate is-alter',],]
                        );?>
                        <?= $form->field($entity, 'id')->hiddenInput()->label(false) ?>
                        <?= Html::hiddenInput('type', \common\models\UserContractorEntity::class) ?>

                        <div class="tab-pane active user-contractor-tab">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <span class="form-note">Статус: Юридическое лицо или ИП
                                        <? if (!empty($lkSettings->contractor_entity)): ?>
                                            <a href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= Html::encode($lkSettings->contractor_entity) ?>">(?)</a>
                                        <? endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <?= Html::checkbox(
                                                'UserContractorEntity[is_default]',
                                                !empty($entity->is_default),
                                                ['id' => 'user-contractor-entity-is_default-'.$entity->id, 'class' => 'custom-control-input', 'value' => 1,]
                                            ) ?>
                                            <label class="custom-control-label" for="user-contractor-entity-is_default-<?= $entity->id ?>"><?= $entity->getAttributeLabel('is_default') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <?= Html::checkbox(
                                                'UserContractorEntity[is_active]',
                                                !empty($entity->is_active),
                                                ['id' => 'user-contractor-entity-is_active-'.$entity->id, 'class' => 'custom-control-input', 'value' => 1,]
                                            ) ?>
                                            <label class="custom-control-label" for="user-contractor-entity-is_active-<?= $entity->id ?>"><?= $entity->getAttributeLabel('is_active') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-entity-inn"><?= $entity->getAttributeLabel('inn') ?> <span class="form-field-required">*</span></label></div>
                                <div class="col-md-7">
                                    <div class="user-contractor-entity-inn-select-container"></div>
                                    <?= $form->field($entity, 'inn')->textInput(['class' => 'form-control user-contractor-entity-inn', 'maxlength' => 12, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                </div>
                                <div class="col-md-2 text-right">
                                    <?= UserHelper::getLoaderIcon() ?>
                                    <a href="#" title="Определить по ИНН" class="btn btn-icon btn-secondary user-contractor-entity-detect-inn"><em class="icon ni ni-eye"></em></a>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-entity-name"><?= $entity->getAttributeLabel('name') ?> <span class="form-field-required">*</span></label></div>
                                <div class="col-md-7">
                                    <div class="user-contractor-entity-name-select-container"></div>
                                    <?= $form->field($entity, 'name')->textInput(['class' => 'form-control user-contractor-entity-name', 'maxlength' => 255, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                </div>
                                <div class="col-md-2 text-right">
                                    <?= UserHelper::getLoaderIcon() ?>
                                    <a href="#" title="Определить по названию" class="btn btn-icon btn-secondary user-contractor-entity-detect-name"><em class="icon ni ni-eye"></em></a>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-entity-kpp"><?= $entity->getAttributeLabel('kpp') ?> <span class="form-field-required">*</span></label></div>
                                <div class="col-md-9"><?= $form->field($entity, 'kpp')->textInput(['class' => 'form-control user-contractor-entity-kpp', 'maxlength' => 9, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-entity-ogrn"><?= $entity->getAttributeLabel('ogrn') ?> <span class="form-field-required">*</span></label></div>
                                <div class="col-md-9"><?= $form->field($entity, 'ogrn')->textInput(['class' => 'form-control user-contractor-entity-ogrn', 'maxlength' => 13, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label class="form-label" for="user-contractor-entity-address"><?= $entity->getAttributeLabel('address') ?> <span class="form-field-required">*</span></label>
                                    <?= $form->field($entity, 'address')->textarea(['class' => 'form-control user-contractor-entity-address',])->label(false) ?>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label class="form-label" for="user-contractor-entity-person"><?= $entity->getAttributeLabel('person') ?></label>
                                    <?= $form->field($entity, 'person')->textInput(['class' => 'form-control user-contractor-entity-person', 'maxlength' => 255, 'required' => false, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label class="form-label" for="user-contractor-entity-reason"><?= $entity->getAttributeLabel('reason') ?></label>
                                    <?= $form->field($entity, 'reason')->textInput(['class' => 'form-control user-contractor-entity-reason', 'maxlength' => 255, 'required' => false, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <div class="nk-block">
                                        <div class="nk-data data-list">
                                            <div class="data-head">
                                                <h6 class="overline-title">
                                                    Формы оплаты
                                                    <? if (!$entity->isNewRecord): ?><a href="#" class="data-head-right" data-toggle="modal" data-target="#contractor-entity-<?= $entity->id ?>-payment-edit-0">Добавить</a><? endif ?>
                                                </h6>
                                            </div>
                                        </div><!-- data-list -->
                                        <div class="nk-block card">
                                            <? if ($entity->isNewRecord): ?>
                                                <div class="alert alert-fill alert-secondary alert-icon">
                                                    <em class="icon ni ni-alert-circle"></em> <strong>Внимание!</strong> Возможность добавления форм оплаты появится после создания юр. лица
                                                </div>
                                            <? else: ?>
                                                <table class="table table-ulogs">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th class="tb-col-os"><span class="overline-title">Тип</span></th>
                                                        <th class="tb-col-time"><span class="overline-title">Информация</span></th>
                                                        <th class="tb-col-time"><span class="overline-title">По умолчанию</span></th>
                                                        <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="user-contractor-entity-<?= $entity->id ?>-payment-container" class="user-contractor-entity-payment-container">
                                                    <? foreach ($entity->payments as $payment): ?>
                                                        <?= UserHelper::getUserContractorEntityPaymentRowHtml($payment, $entity->id) ?>
                                                    <? endforeach ?>
                                                    </tbody>
                                                </table>
                                            <? endif ?>
                                        </div><!-- .nk-block-head -->
                                    </div><!-- .nk-block -->
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li><?= Html::submitButton('Сохранить', ['class' => 'btn btn-lg btn-primary',]) ?></li>
                                        <li><a href="#" data-dismiss="modal" class="link link-light">Отмена</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                        <?php ActiveForm::end(); ?>
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    <?
    if (!$entity->isNewRecord) {
        $newPayment->entity_id = $entity->id;
        $payments = $entity->payments;
        $payments[] = $newPayment;
    ?>
        <? foreach ($payments as $payment): ?>
        <? $paymentEditModalID = 'contractor-entity-'.$entity->id.'-payment-edit-'.$payment->id; ?>
        <div class="modal fade zoom" tabindex="-1" role="dialog" id="<?= $paymentEditModalID ?>">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-lg">
                        <h5 class="title"><?= $payment->isNewRecord ? 'Добавить' : 'Изменить' ?> форму оплаты</h5>
                        <div class="tab-content">
                            <?php
                            $formID = 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-form';
                            $formPayment = ActiveForm::begin([
                                'action' => '/contractors/entity-payment-save',
                                'id' => $formID,
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => false,
                                'validationUrl' => ['/contractors/payment-check',],
                                'method' => 'post',
//                                'options' => ['novalidate' => true,],
                            ]);?>
                            <?= $formPayment->field($payment, 'id')->hiddenInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-id',])->label(false) ?>
                            <?= $formPayment->field($payment, 'entity_id')->hiddenInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-entity_id',])->label(false) ?>

                            <div class="tab-pane active user-contractor-payment-tab">
                                <div class="row gy-4">
                                    <div class="col-md-3"><label class="form-label" for="user-contractor-payment-type"><?= $payment->getAttributeLabel('type') ?> <span class="form-field-required">*</span></label></div>
                                    <div class="col-md-9"><?= $formPayment->field($payment, 'type')->dropDownList($payment->getTypeOptions(), [$payment->type => ['selected' => true,], 'id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-type', 'class' => 'form-control user-contractor-entity-payment-type', 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                </div>
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <?= Html::checkbox(
                                                    'UserContractorPayment[is_default]',
                                                    !empty($payment->is_default),
                                                    ['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-is_default', 'class' => 'custom-control-input', 'value' => 1,]
                                                ) ?>
                                                <label class="custom-control-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-is_default"><?= $payment->getAttributeLabel('is_default') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="user-contractor-payment-type-<?= UserContractorPayment::TYPE_TRANSFER ?>-container" style="display: <?= $payment->type === UserContractorPayment::TYPE_TRANSFER ? 'block' : 'none' ?>;">
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-bik"><?= $payment->getAttributeLabel('bik') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-7">
                                            <?= $formPayment->field($payment, 'bik')->textInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-bik', 'class' => 'form-control user-contractor-payment-bik', 'maxlength' => 20, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <?= UserHelper::getLoaderIcon() ?>
                                            <a href="#" title="Определить по БИК" class="btn btn-icon btn-secondary user-contractor-payment-detect-bik"><em class="icon ni ni-eye"></em></a>
                                        </div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-correspondent_account"><?= $payment->getAttributeLabel('correspondent_account') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-9"><?= $formPayment->field($payment, 'correspondent_account')->textInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-correspondent_account', 'class' => 'form-control user-contractor-payment-correspondent_account', 'maxlength' => 20, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-bank"><?= $payment->getAttributeLabel('bank') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-9"><?= $formPayment->field($payment, 'bank')->textInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-bank', 'class' => 'form-control user-contractor-payment-bank', 'maxlength' => 255, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-payment_account"><?= $payment->getAttributeLabel('payment_account') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-9"><?= $formPayment->field($payment, 'payment_account')->textInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-payment_account', 'class' => 'form-control user-contractor-payment-payment_account', 'maxlength' => 50, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                    </div>
                                </div>
                                <div class="user-contractor-payment-type-<?= UserContractorPayment::TYPE_CASH ?>-container" style="display: <?= $payment->type === UserContractorPayment::TYPE_CASH ? 'block' : 'none' ?>;"></div>
                                <div class="user-contractor-payment-type-<?= UserContractorPayment::TYPE_CARD ?>-container" style="display: <?= $payment->type === UserContractorPayment::TYPE_CARD ? 'block' : 'none' ?>;">
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-number"><?= $payment->getAttributeLabel('number') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-9"><?= $formPayment->field($payment, 'number')->textInput(['id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-number', 'class' => 'form-control user-contractor-payment-number', 'maxlength' => 255,  'placeholder' => 'Номер карты','data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-month"><?= $payment->getAttributeLabel('month') ?> <span class="form-field-required">*</span></label>
                                            <?= $formPayment->field($payment, 'month')->dropDownList($payment->getMonthOptions(), [$payment->month => ['selected' => true,], 'id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-month', 'class' => 'form-control user-contractor-payment-month', 'data-msg' => 'Пожалуйста, выберите значение',])->label(false) ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="user-contractor-entity-<?= $entity->id ?>-payment-<?= $payment->id ?>-year"><?= $payment->getAttributeLabel('year') ?> <span class="form-field-required">*</span></label>
                                            <?= $formPayment->field($payment, 'year')->dropDownList($payment->getYearOptions(), [$payment->year => ['selected' => true,], 'id' => 'user-contractor-entity-'.$entity->id.'-payment-'.$payment->id.'-year', 'class' => 'form-control user-contractor-payment-year', 'data-msg' => 'Пожалуйста, выберите значение',])->label(false) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row gy-4">
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li><?= Html::submitButton('Сохранить', ['class' => 'btn btn-lg btn-primary',]) ?></li>
                                            <li><a href="#" data-dismiss="modal" class="link link-light">Отмена</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .tab-pane -->
                            <?php ActiveForm::end(); ?>
                        </div><!-- .tab-content -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div><!-- .modal -->
        <?
        $js = '
            jQuery("#'.$formID.'").on("beforeSubmit", function () {
                let $yiiform = jQuery(this);
                let container = jQuery("#user-contractor-entity-'.$entity->id.'-payment-container");
                
                // отправляем данные на сервер
                jQuery.ajax({
                        type: $yiiform.attr("method"),
                        url: $yiiform.attr("action"),
                        data: $yiiform.serializeArray()
                }).done(function(data) {
                   if(data.ok) {
                      app.showSuccessMessage("Форма оплаты сохранена");
                      
                      let isFound = false;
                      jQuery.each(container.find("tr"), function( index, tr ) {
                        if (jQuery(tr).data("id") === data.id) {
                            container.find("tr")[index].replaceWith(jQuery(data.html));
                            isFound = true;
                        }
                      });
                      if (!isFound) {
                        container.append(jQuery(data.html));
                      }
                      
                      jQuery("#'.$paymentEditModalID.'").modal("hide");
                    } else {
                      app.showErrorMessage("Ошибка сохранения формы");
                    }
                }).fail(function () {
                     app.showErrorMessage("Ошибка передачи данных");
                     jQuery("#'.$formID.'").modal("hide");
                });
            
                return false; // отменяем отправку данных формы
            });
        ';

        $this->registerJs($js);
        ?>
        <? endforeach ?>
    <? } ?>
<? endforeach ?>

<? foreach ($persons as $person): ?>
    <!-- @@ contractor Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="contractor-person-edit-<?= $person->id ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title"><?= $person->isNewRecord ? 'Добавить' : 'Изменить' ?> частное лицо</h5>
                    <div class="tab-content">
                        <?php $form = ActiveForm::begin([
                            'validationUrl' => ['/contractors/person-check',],
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => true,
                            'options' => ['class' => 'form-validate is-alter',],]
                        );?>
                        <?= $form->field($person, 'id')->hiddenInput()->label(false) ?>
                        <?= Html::hiddenInput('type', \common\models\UserContractorPerson::class) ?>

                        <div class="tab-pane active user-contractor-tab">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <span class="form-note">Статус: Частное лицо
                                        <? if (!empty($lkSettings->contractor_person)): ?>
                                            <a href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= Html::encode($lkSettings->contractor_person) ?>">(?)</a>
                                        <? endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <?= Html::checkbox(
                                                'UserContractorPerson[is_default]',
                                                !empty($person->is_default),
                                                ['id' => 'user-contractor-person-is_default-'.$person->id, 'class' => 'custom-control-input', 'value' => 1,]
                                            ) ?>
                                            <label class="custom-control-label" for="user-contractor-person-is_default-<?= $person->id ?>"><?= $person->getAttributeLabel('is_default') ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <?= Html::checkbox(
                                                'UserContractorPerson[is_active]',
                                                !empty($person->is_active),
                                                ['id' => 'user-contractor-person-is_active-'.$person->id, 'class' => 'custom-control-input', 'value' => 1,]
                                            ) ?>
                                            <label class="custom-control-label" for="user-contractor-person-is_active-<?= $person->id ?>"><?= $person->getAttributeLabel('is_active') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <a href="#" class="user-contractor-person-fill">Заполнить по данным основного контактного лица</a> <?= UserHelper::getLoaderIcon() ?>
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-person-<?= $person->id ?>-firstname"><?= $person->getAttributeLabel('firstname') ?></label></div>
                                <div class="col-md-9"><?= $form->field($person, 'firstname')->textInput(['id' => 'user-contractor-person-'.$person->id.'-firstname', 'class' => 'form-control user-contractor-person-firstname', 'maxlength' => 50, 'required' => false,])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-person-<?= $person->id ?>-lastname"><?= $person->getAttributeLabel('lastname') ?></label></div>
                                <div class="col-md-9"><?= $form->field($person, 'lastname')->textInput(['id' => 'user-contractor-person-'.$person->id.'-lastname', 'class' => 'form-control user-contractor-person-lastname', 'maxlength' => 50, 'required' => false,])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-person-<?= $person->id ?>-secondname"><?= $person->getAttributeLabel('secondname') ?></label></div>
                                <div class="col-md-9"><?= $form->field($person, 'secondname')->textInput(['id' => 'user-contractor-person-'.$person->id.'-secondname', 'class' => 'form-control user-contractor-person-secondname', 'maxlength' => 50, 'required' => false,])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-3"><label class="form-label" for="user-contractor-person-<?= $person->id ?>-address"><?= $person->getAttributeLabel('address') ?></label></div>
                                <div class="col-md-9"><?= $form->field($person, 'address')->textInput(['id' => 'user-contractor-person-'.$person->id.'-address', 'class' => 'form-control user-contractor-person-address', 'maxlength' => 255, 'required' => false,])->label(false) ?></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <div class="nk-block">
                                        <div class="nk-data data-list">
                                            <div class="data-head">
                                                <h6 class="overline-title">
                                                    Формы оплаты
                                                    <? if (!$person->isNewRecord): ?><a href="#" class="data-head-right" data-toggle="modal" data-target="#contractor-person-<?= $person->id ?>-payment-edit-0">Добавить</a><? endif ?>
                                                </h6>
                                            </div>
                                        </div><!-- data-list -->
                                        <div class="nk-block card">
                                            <? if ($person->isNewRecord): ?>
                                                <div class="alert alert-fill alert-secondary alert-icon">
                                                    <em class="icon ni ni-alert-circle"></em> <strong>Внимание!</strong> Возможность добавления форм оплаты появится после создания физ. лица
                                                </div>
                                            <? else: ?>
                                                <table class="table table-ulogs">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th class="tb-col-os"><span class="overline-title">Тип</span></th>
                                                        <th class="tb-col-time"><span class="overline-title">Информация</span></th>
                                                        <th class="tb-col-time"><span class="overline-title">По умолчанию</span></th>
                                                        <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="user-contractor-person-<?= $person->id ?>-payment-container" class="user-contractor-person-payment-container">
                                                    <? foreach ($person->payments as $payment): ?>
                                                        <?= UserHelper::getUserContractorPersonPaymentRowHtml($payment, $person->id) ?>
                                                    <? endforeach ?>
                                                    </tbody>
                                                </table>
                                            <? endif ?>
                                        </div><!-- .nk-block-head -->
                                    </div><!-- .nk-block -->
                                </div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li><?= Html::submitButton('Сохранить', ['class' => 'btn btn-lg btn-primary',]) ?></li>
                                        <li><a href="#" data-dismiss="modal" class="link link-light">Отмена</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                        <?php ActiveForm::end(); ?>
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    <?
    if (!$person->isNewRecord) {
        $newPayment->person_id = $person->id;
        $newPayment->type = UserContractorPayment::TYPE_CARD;
        $payments = $person->payments;
        $payments[] = $newPayment;
        ?>
        <? foreach ($payments as $payment): ?>
            <? $paymentEditModalID = 'contractor-person-'.$person->id.'-payment-edit-'.$payment->id; ?>
            <div class="modal fade zoom" tabindex="-1" role="dialog" id="<?= $paymentEditModalID ?>">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-lg">
                            <h5 class="title"><?= $payment->isNewRecord ? 'Добавить' : 'Изменить' ?> форму оплаты</h5>
                            <div class="tab-content">
                                <?php
                                $formID = 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-form';
                                $formPayment = ActiveForm::begin([
                                    'action' => '/contractors/person-payment-save',
                                    'id' => $formID,
                                    'enableClientValidation' => false,
                                    'enableAjaxValidation' => false,
                                    'validationUrl' => ['/contractors/payment-check',],
                                    'method' => 'post',
                                    //                                'options' => ['novalidate' => true,],
                                ]);?>
                                <?= $formPayment->field($payment, 'id')->hiddenInput(['id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-id',])->label(false) ?>
                                <?= $formPayment->field($payment, 'person_id')->hiddenInput(['id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-person_id',])->label(false) ?>

                                <div class="tab-pane active user-contractor-payment-tab">
                                    <div class="row gy-4">
                                        <div class="col-md-3"><label class="form-label" for="user-contractor-payment-type"><?= $payment->getAttributeLabel('type') ?> <span class="form-field-required">*</span></label></div>
                                        <div class="col-md-9"><?= $formPayment->field($payment, 'type')->dropDownList($payment->getPersonTypeOptions(), [$payment->type => ['selected' => true,], 'id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-type', 'class' => 'form-control user-contractor-person-payment-type', 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <?= Html::checkbox(
                                                        'UserContractorPayment[is_default]',
                                                        !empty($payment->is_default),
                                                        ['id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-is_default', 'class' => 'custom-control-input', 'value' => 1,]
                                                    ) ?>
                                                    <label class="custom-control-label" for="user-contractor-person-<?= $person->id ?>-payment-<?= $payment->id ?>-is_default"><?= $payment->getAttributeLabel('is_default') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="user-contractor-payment-type-<?= UserContractorPayment::TYPE_CARD ?>-container" style="display: <?= $payment->type === UserContractorPayment::TYPE_CARD ? 'block' : 'none' ?>;">
                                        <div class="row gy-4">
                                            <div class="col-md-3"><label class="form-label" for="user-contractor-person-<?= $person->id ?>-payment-<?= $payment->id ?>-number"><?= $payment->getAttributeLabel('number') ?> <span class="form-field-required">*</span></label></div>
                                            <div class="col-md-9"><?= $formPayment->field($payment, 'number')->textInput(['id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-number', 'class' => 'form-control user-contractor-payment-number', 'maxlength' => 255,  'placeholder' => 'Номер карты','data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                                        </div>
                                        <div class="row gy-4">
                                            <div class="col-md-6">
                                                <label class="form-label" for="user-contractor-person-<?= $person->id ?>-payment-<?= $payment->id ?>-month"><?= $payment->getAttributeLabel('month') ?> <span class="form-field-required">*</span></label>
                                                <?= $formPayment->field($payment, 'month')->dropDownList($payment->getMonthOptions(), [$payment->month => ['selected' => true,], 'id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-month', 'class' => 'form-control user-contractor-payment-month', 'data-msg' => 'Пожалуйста, выберите значение',])->label(false) ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="user-contractor-person-<?= $person->id ?>-payment-<?= $payment->id ?>-year"><?= $payment->getAttributeLabel('year') ?> <span class="form-field-required">*</span></label>
                                                <?= $formPayment->field($payment, 'year')->dropDownList($payment->getYearOptions(), [$payment->year => ['selected' => true,], 'id' => 'user-contractor-person-'.$person->id.'-payment-'.$payment->id.'-year', 'class' => 'form-control user-contractor-payment-year', 'data-msg' => 'Пожалуйста, выберите значение',])->label(false) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-contractor-payment-type-<?= UserContractorPayment::TYPE_CASH ?>-container" style="display: <?= $payment->type === UserContractorPayment::TYPE_CASH ? 'block' : 'none' ?>;"></div>

                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li><?= Html::submitButton('Сохранить', ['class' => 'btn btn-lg btn-primary',]) ?></li>
                                                <li><a href="#" data-dismiss="modal" class="link link-light">Отмена</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .tab-pane -->
                                <?php ActiveForm::end(); ?>
                            </div><!-- .tab-content -->
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div><!-- .modal -->
            <?
            $js = '
            jQuery("#'.$formID.'").on("beforeSubmit", function () {
                let $yiiform = jQuery(this);
                let container = jQuery("#user-contractor-person-'.$person->id.'-payment-container");
                
                // отправляем данные на сервер
                jQuery.ajax({
                        type: $yiiform.attr("method"),
                        url: $yiiform.attr("action"),
                        data: $yiiform.serializeArray()
                }).done(function(data) {
                   if(data.ok) {
                      app.showSuccessMessage("Форма оплаты сохранена");
                      
                      let isFound = false;
                      jQuery.each(container.find("tr"), function( index, tr ) {
                        if (jQuery(tr).data("id") === data.id) {
                            container.find("tr")[index].replaceWith(jQuery(data.html));
                            isFound = true;
                        }
                      });
                      if (!isFound) {
                        container.append(jQuery(data.html));
                      }
                      
                      jQuery("#'.$paymentEditModalID.'").modal("hide");
                    } else {
                      app.showErrorMessage("Ошибка сохранения формы");
                    }
                }).fail(function () {
                     app.showErrorMessage("Ошибка передачи данных");
                     jQuery("#'.$formID.'").modal("hide");
                });
            
                return false; // отменяем отправку данных формы
            });
        ';
        $this->registerJs($js);
        ?>
        <? endforeach ?>
    <? } ?>
<? endforeach ?>