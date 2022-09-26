<?php

/* @var $this yii\web\View */
/* @var $deliveries \common\models\UserDelivery[] */
/* @var $lkSettings \common\models\LkSettings */

$this->title = 'Адреса доставки';
$this->params['breadcrumbs'][] = $this->title;

use common\components\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <div class="nk-block-des">
            <p>Здесь вы можете управлять адресами доставки для своего аккаунта. <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
        </div>
    </div>
</div>
<div class="nk-block">
    <div class="nk-data data-list">
        <div class="data-head">
            <h6 class="overline-title">
                <?= $this->title ?>
                <a href="#" class="data-head-right" data-toggle="modal" data-target="#delivery-edit-0">Добавить</a>
            </h6>
        </div>
    </div><!-- data-list -->
    <div class="nk-block card">
        <table class="table table-ulogs">
            <thead class="thead-light">
            <tr>
                <th class="tb-col-os"><span class="overline-title">Город</span></th>
                <th class="tb-col-time"><span class="overline-title">Улица</span></th>
                <th class="tb-col-time"><span class="overline-title">Дом</span></th>
                <th class="tb-col-time"><span class="overline-title">Индекс</span></th>
                <th class="tb-col-time"><span class="overline-title">Основной</span></th>
                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
            </tr>
            </thead>
            <tbody id="user-delivery-container">
            <? foreach ($deliveries as $delivery): ?>
                <? if (!$delivery->isNewRecord): ?>
                <tr>
                    <td class="tb-col-os"><?= $delivery->city ?></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $delivery->street ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $delivery->house ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $delivery->index ?: '' ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $delivery->is_main ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ?></span></td>
                    <td class="tb-col-action">
                        <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#delivery-edit-<?= $delivery->id ?>"><em class="icon ni ni-edit"></em></a>
                        <? if (!$delivery->is_main): ?>
                            <?= Html::a('<em class="icon ni ni-trash"></em>', ['/delivery/delete', 'id' => $delivery->id], [
                                'class' => 'link-cross mr-sm-n1',
                                'data' => [
                                    'confirm' => 'Действительно удалить этот адрес?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <? endif; ?>
                    </td>
                </tr>
                <? endif ?>
            <? endforeach ?>
            </tbody>
        </table>
    </div><!-- .nk-block-head -->
</div><!-- .nk-block -->

<? foreach ($deliveries as $delivery): ?>
<!-- @@ Delivery Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="delivery-edit-<?= $delivery->id ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title"><?= $delivery->isNewRecord ? 'Добавить' : 'Изменить' ?> адрес доставки</h5>
                <div class="tab-content">
                    <?php $form = ActiveForm::begin([
                        'validationUrl' => ['/delivery/check',],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-validate is-alter',],]
                    );?>
                    <?= $form->field($delivery, 'id')->hiddenInput()->label(false) ?>

                    <div class="tab-pane active user-delivery-tab">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"><?= $delivery->getAttributeLabel('title') ?> <span class="form-field-required">*</span></label>
                                    <span class="form-note">Например "Адрес домашний" или "Адрес офиса"
                                    <? if (!empty($lkSettings->delivery_address)): ?>
                                        <a href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= Html::encode($lkSettings->delivery_address) ?>">(?)</a>
                                    <? endif; ?>
                                    </span>
                                    <div class="form-control-wrap">
                                        <?= $form->field($delivery, 'title')->textInput(['class' => 'form-control', 'maxlength' => 150, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserDelivery[is_main]',
                                            !empty($delivery->is_main),
                                            ['id' => 'user-delivery-is_main-'.$delivery->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-delivery-is_main-<?= $delivery->id ?>"><?= $delivery->getAttributeLabel('is_main') ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-country"><?= $delivery->getAttributeLabel('country') ?> <span class="form-field-required">*</span></label></div>
                            <div class="col-md-9"><?= $form->field($delivery, 'country')->textInput(['class' => 'form-control user-delivery-country', 'maxlength' => 100, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-region"><?= $delivery->getAttributeLabel('region') ?> <span class="form-field-required">*</span></label></div>
                            <div class="col-md-9"><?= $form->field($delivery, 'region')->textInput(['class' => 'form-control user-delivery-region', 'maxlength' => 100, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-city"><?= $delivery->getAttributeLabel('city') ?> <span class="form-field-required">*</span></label></div>
                            <div class="col-md-9"><?= $form->field($delivery, 'city')->textInput(['class' => 'form-control user-delivery-city', 'maxlength' => 100, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-street"><?= $delivery->getAttributeLabel('street') ?> <span class="form-field-required">*</span></label></div>
                            <div class="col-md-9"><?= $form->field($delivery, 'street')->textInput(['class' => 'form-control user-delivery-street', 'maxlength' => 100, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-house"><?= $delivery->getAttributeLabel('house') ?> <span class="form-field-required">*</span></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'house')->textInput(['class' => 'form-control user-delivery-house', 'maxlength' => 25, 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?></div>
                            <div class="col-md-3"><label class="form-label" for="user-delivery-apartment"><?= $delivery->getAttributeLabel('apartment') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'apartment')->textInput(['class' => 'form-control user-delivery-apartment', 'maxlength' => 10,])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-building"><?= $delivery->getAttributeLabel('building') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'building')->textInput(['class' => 'form-control user-delivery-building', 'maxlength' => 25,])->label(false) ?></div>
                            <div class="col-md-3"><label class="form-label" for="user-delivery-structure"><?= $delivery->getAttributeLabel('structure') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'structure')->textInput(['class' => 'form-control user-delivery-structure', 'maxlength' => 25,])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-entrance"><?= $delivery->getAttributeLabel('entrance') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'entrance')->textInput(['class' => 'form-control user-delivery-entrance', 'maxlength' => 10,])->label(false) ?></div>
                            <div class="col-md-3"><label class="form-label" for="user-delivery-floor"><?= $delivery->getAttributeLabel('floor') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'floor')->textInput(['class' => 'form-control user-delivery-floor', 'maxlength' => 10,])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-index"><?= $delivery->getAttributeLabel('index') ?></label></div>
                            <div class="col-md-3"><?= $form->field($delivery, 'index')->textInput(['class' => 'form-control user-delivery-index', 'maxlength' => 10,])->label(false) ?></div>
                            <div class="col-md-6"><a href="#" class="user-delivery-index-detect"><em class="ni ni-map-pin-fill"></em> Определить индекс по адресу</a> <?= UserHelper::getLoader() ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-delivery-info"><?= $delivery->getAttributeLabel('info') ?></label></div>
                            <div class="col-md-9"><?= $form->field($delivery, 'info')->textarea(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserDelivery[is_post]',
                                            !empty($delivery->is_post),
                                            ['id' => 'user-delivery-is_post-'.$delivery->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-delivery-is_post-<?= $delivery->id ?>"><?= $delivery->getAttributeLabel('is_post') ?></label>
                                    </div>
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
<? endforeach ?>