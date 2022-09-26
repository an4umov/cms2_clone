<?php

/* @var $this yii\web\View */
/* @var $user \cabinet\components\UserLk */
/* @var $model \common\models\UserLk */
/* @var $contacts \common\models\UserContact[] */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
$phone = $user->getPhone();

use \common\models\UserContact;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\components\helpers\UserHelper;
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h3 class="nk-block-title fw-normal">Информация об аккаунте</h3>
        <div class="nk-block-des">
            <p>Здесь вы можете изменить настройки своего аккаунта. <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
        </div>
    </div>
</div>
<ul class="nk-nav nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="/settings">Профиль</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/settings/security">Настройка<span class="d-none s-sm-inline"> аккаунта</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/settings/notice">Подписки<span class="d-none s-sm-inline"> и извещения</span></a>
    </li>
</ul><!-- .nav-tabs -->
<div class="nk-block">
    <div class="nk-data data-list">
        <div class="data-head">
            <h6 class="overline-title">Регистрационные данные</h6>
        </div>
        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
            <div class="data-col">
                <span class="data-label">Наименование покупателя</span>
                <span class="data-value"><?= $user->getDisplayName() ?></span>
            </div>
            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
        </div><!-- data-item -->
        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
            <div class="data-col">
                <span class="data-label">Телефон</span>
                <span class="data-value text-soft"><?= $phone ?: 'Не задан' ?></span>
            </div>
            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
        </div><!-- data-item -->
        <div class="data-item">
            <div class="data-col">
                <span class="data-label">Email</span>
                <span class="data-value"><?= $user->getEmail() ?></span>
            </div>
            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
        </div><!-- data-item -->
        <div class="data-item">
            <div class="data-col">
                <span class="data-label">Статус</span>
                <span class="data-value text-soft"><?= $user->getStatusTitle() ?></span>
            </div>
            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
        </div>
    </div><!-- data-list -->
    <div class="nk-data data-list">
        <div class="data-head">
                <h6 class="overline-title">
                    Контактные лица
                    <a href="#" class="data-head-right" data-toggle="modal" data-target="#contact-edit-0">Добавить</a>
                </h6>

        </div>
    </div><!-- data-list -->
    <div class="nk-block card">
        <table class="table table-ulogs">
            <thead class="thead-light">
            <tr>
                <th class="tb-col-os"><span class="overline-title">ФИО</span></th>
                <th class="tb-col-time"><span class="overline-title">Должность</span></th>
                <th class="tb-col-time"><span class="overline-title">Email</span></th>
                <th class="tb-col-time"><span class="overline-title">Основной</span></th>
                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
            </tr>
            </thead>
            <tbody id="user-contacts-container">
            <? foreach ($contacts as $contact): ?>
                <? if (!$contact->isNewRecord): ?>
                <tr>
                    <td class="tb-col-os"><?= UserHelper::getFIO($contact) ?></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $contact->position ?: '' ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $contact->email ?: '' ?></span></td>
                    <td class="tb-col-ip"><span class="sub-text"><?= $contact->is_main ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ?></span></td>
                    <td class="tb-col-action">
                        <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#contact-edit-<?= $contact->id ?>"><em class="icon ni ni-edit"></em></a>
                        <?= Html::a('<em class="icon ni ni-trash"></em>', ['/settings/delete-contact', 'id' => $contact->id], [
                            'class' => 'link-cross mr-sm-n1',
                            'data' => [
                                'confirm' => 'Действительно удалить этот контакт?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <? endif ?>
            <? endforeach ?>
            </tbody>
        </table>
    </div><!-- .nk-block-head -->
</div><!-- .nk-block -->

<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Изменить профиль</h5>
                <ul class="nk-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal">Личные данные</a>
                    </li>
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => false, 'options' => ['class' => 'form-validate is-alter',],]); ?>
                    <?= Html::hiddenInput('action', UserHelper::PROFILE_ACTION_INFO) ?>
                    <div class="tab-pane active" id="personal">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Наименование покупателя</label>
                                    <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'class' => 'form-control form-control-lg', 'placeholder' => 'Укажите имя', 'required' => true, 'data-msg' => 'Пожалуйста, заполните поле',])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Телефон</label>
                                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 25, 'class' => 'form-control form-control-lg', 'placeholder' => 'Укажите телефон с кодом страны',])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <?= Html::submitButton('Обновить', ['class' => 'btn btn-lg btn-primary',]) ?>
                                    </li>
                                    <li>
                                        <a href="#" data-dismiss="modal" class="link link-light">Отмена</a>
                                    </li>
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

<? foreach ($contacts as $contact): ?>
<!-- @@ Contact Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="contact-edit-<?= $contact->id ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title"><?= $contact->isNewRecord ? 'Добавить' : 'Изменить' ?> контактное лицо</h5>
                <div class="tab-content">
                    <?php $form = ActiveForm::begin([
                        'validationUrl' => ['/settings/check-contact',],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-validate is-alter',],]
                    );?>
                    <?= Html::hiddenInput('action', UserHelper::PROFILE_ACTION_CONTACT) ?>
                    <?= $form->field($contact, 'id')->hiddenInput()->label(false) ?>

                    <div class="tab-pane active" id="personal">
                        <div class="row gy-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="preview-block">
                                    <div class="custom-control custom-radio">
                                        <?= Html::radio(
                                                'UserContact[sex]',
                                                $contact->sex === UserContact::SEX_MALE,
                                                ['id' => 'user-contact-sex-male-'.$contact->id, 'class' => 'custom-control-input', 'value' => \common\models\UserContact::SEX_MALE,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-contact-sex-male-<?= $contact->id ?>"><?= UserHelper::getSexTitle(\common\models\UserContact::SEX_MALE) ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="preview-block">
                                    <div class="custom-control custom-radio">
                                        <?= Html::radio(
                                            'UserContact[sex]',
                                            $contact->sex === UserContact::SEX_FEMALE,
                                            ['id' => 'user-contact-sex-female-'.$contact->id, 'class' => 'custom-control-input', 'value' => \common\models\UserContact::SEX_FEMALE,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-contact-sex-female-<?= $contact->id ?>"><?= UserHelper::getSexTitle(\common\models\UserContact::SEX_FEMALE) ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-lastname"><?= $contact->getAttributeLabel('lastname') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'lastname')->textInput(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-firstname"><?= $contact->getAttributeLabel('firstname') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'firstname')->textInput(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-secondname"><?= $contact->getAttributeLabel('secondname') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'secondname')->textInput(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-email"><?= $contact->getAttributeLabel('email') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'email')->textInput(['class' => 'form-control', 'type' => 'email',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-position"><?= $contact->getAttributeLabel('position') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'position')->textInput(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3">
                                <label class="form-label" for="user-contact-phones"><?= $contact->getAttributeLabel('phones') ?></label>
                                <?= UserHelper::getLoader() ?>
                            </div>
                            <div class="col-md-9">
                                <?
                                $phones = $contact->getPhones();
                                $firstPhone = '';
                                if (!empty($phones) && is_array($phones)) {
                                    $firstPhone = array_shift($phones);
                                }
                                ?>
                                <?= Html::input('phone', 'UserContact[phones][]', $firstPhone, ['class' => 'form-control user-contact-phones-input',]) ?>
                                <div class="tb-col-action user-contact-phones-actions">
                                    <a href="#" class="link-cross mr-sm-n1 user-contact-phones-add"><em class="icon ni ni-plus-circle"></em></a>
                                </div>
                                <div class="user-contact-phones-container">
                                    <? foreach ($phones as $phone): ?>
                                    <div class="user-contact-phones-container-item">
                                        <?= Html::input('phone', 'UserContact[phones][]', $phone, ['class' => 'form-control user-contact-phones-input',]) ?>
                                        <div class="tb-col-action user-contact-phones-actions">
                                            <a href="#" class="link-cross mr-sm-n1 user-contact-phones-delete"><em class="icon ni ni-trash"></em></a>
                                        </div>
                                    </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"><label class="form-label" for="user-contact-info"><?= $contact->getAttributeLabel('info') ?></label></div>
                            <div class="col-md-9"><?= $form->field($contact, 'info')->textarea(['class' => 'form-control',])->label(false) ?></div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserContact[is_main]',
                                            !empty($contact->is_main),
                                            ['id' => 'user-contact-is_main-'.$contact->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-contact-is_main-<?= $contact->id ?>"><?= $contact->getAttributeLabel('is_main') ?></label>
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