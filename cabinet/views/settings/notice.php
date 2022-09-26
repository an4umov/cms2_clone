<?php

/* @var $this yii\web\View */
/* @var $notice \common\models\UserNotice */
/* @var $mailing array */
/* @var $emails array */
/* @var $phones array */

$this->title = 'Подписки и извещения';
$this->params['breadcrumbs'][] = $this->title;

use common\models\UserMailing;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <div class="nk-block-head-sub"><a class="back-to" href="/settings"><em class="icon ni ni-arrow-left"></em><span>Профиль</span></a></div>
        <h3 class="nk-block-title fw-normal"><?= $this->title ?></h3>
    </div>
</div><!-- .nk-block-head -->
<ul class="nk-nav nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="/settings/index">Профиль</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/settings/security">Настройка<span class="d-none s-sm-inline"> аккаунта</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/settings/notice">Подписки<span class="d-none s-sm-inline"> и извещения</span></a>
    </li>
</ul><!-- .nav-tabs -->
<div class="nk-block">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title"><?= $this->title ?></h5>
            <div class="nk-block-des">
                <p>Вы можете управлять настройкой извещений и новостей, которые мы будем Вам отправлять.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->
    <div class="card card-bordered">
        <div class="card-inner-group">
            <div class="card-inner card-inner-lg">
                <?php $form = ActiveForm::begin([
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'options' => ['class' => 'form-validate is-alter',],]
                );?>
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-head-content">
                        <h6>Статусы заказов</h6>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block-content">
                    <div class="gy-3">
                        <div class="nk-block-text">
                            <strong class="user-balance-sub">Получение Вашего заказа из Интернет-магазина</strong>
                        </div>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_order_received_email]',
                                            !empty($notice->is_order_received_email),
                                            ['id' => 'user-notice-is_order_received_email-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_order_received_email-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_order_received_email') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[order_received_email]',
                                        $notice->order_received_email,
                                        $emails,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? if ($phones): ?>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_order_received_sms]',
                                            !empty($notice->is_order_received_sms),
                                            ['id' => 'user-notice-is_order_received_sms-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_order_received_sms-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_order_received_sms') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[order_received_sms]',
                                        $notice->order_received_sms,
                                        $phones,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? endif; ?>
                    </div>
                    <div class="gy-3">
                        <div class="nk-block-text">
                            <strong class="user-balance-sub">Изменение статуса Вашего заказа</strong>
                        </div>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_order_status_email]',
                                            !empty($notice->is_order_status_email),
                                            ['id' => 'user-notice-is_order_status_email-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_order_status_email-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_order_status_email') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[order_status_email]',
                                        $notice->order_status_email,
                                        $emails,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? if ($phones): ?>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_order_status_sms]',
                                            !empty($notice->is_order_status_sms),
                                            ['id' => 'user-notice-is_order_status_sms-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_order_status_sms-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_order_status_sms') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[order_status_sms]',
                                        $notice->order_status_sms,
                                        $phones,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? endif; ?>
                    </div>
                    <div class="gy-3">
                        <div class="nk-block-text">
                            <strong class="user-balance-sub">Изменение баланса взаиморасчетов (поступления и списания денег)</strong>
                        </div>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_balance_email]',
                                            !empty($notice->is_balance_email),
                                            ['id' => 'user-notice-is_balance_email-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_balance_email-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_balance_email') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[balance_email]',
                                        $notice->balance_email,
                                        $emails,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? if ($phones): ?>
                        <div class="g-item">
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="custom-control custom-switch">
                                        <?= Html::checkbox(
                                            'UserNotice[is_balance_sms]',
                                            !empty($notice->is_balance_sms),
                                            ['id' => 'user-notice-is_balance_sms-'.$notice->id, 'class' => 'custom-control-input', 'value' => 1,]
                                        ) ?>
                                        <label class="custom-control-label" for="user-notice-is_balance_sms-<?= $notice->id ?>"><?= $notice->getAttributeLabel('is_balance_sms') ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <?= Html::dropDownList(
                                        'UserNotice[balance_sms]',
                                        $notice->balance_sms,
                                        $phones,
                                        ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                        <? endif; ?>
                    </div>
                </div><!-- .nk-block-content -->



                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-head-content">
                        <h6>Рассылки по электронной почте</h6>
                        <div class="nk-block-des">
                            <p>Отметьте те рассылки, которые Вы хотите получать.</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block-content">
                    <? foreach ($mailing as $item): ?>
                        <div class="gy-3">
                            <div class="nk-block-text">
                                <strong class="user-balance-sub"><?= $item['name'] ?></strong>
                                <footer class="blockquote-footer"><?= $item['description'] ?></footer>
                            </div>
                            <div class="g-item">
                                <div class="row gy-4">
                                    <div class="col-sm-3">
                                        <div class="custom-control custom-switch">
                                            <?= Html::hiddenInput(
                                                'UserMailing['.$item['id'].'][id]',
                                                $item[UserMailing::tableName()]->id
                                            ) ?>
                                            <?= Html::checkbox(
                                                'UserMailing['.$item['id'].'][is_enabled]',
                                                !empty($item[UserMailing::tableName()]->is_enabled),
                                                ['id' => 'user-notice-lk_mailing-'.$item['id'], 'class' => 'custom-control-input', 'value' => 1,]
                                            ) ?>
                                            <label class="custom-control-label" for="user-notice-lk_mailing-<?= $item['id'] ?>">E-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <?= Html::dropDownList(
                                            'UserMailing['.$item['id'].'][email]',
                                            $item[UserMailing::tableName()]->email,
                                            $emails,
                                            ['class' => 'form-select form-control form-control-lg', 'prompt' => 'Выбрать...',]
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div><!-- .nk-block-content -->
                <div class="row gy-4">
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li><?= Html::submitButton('Сохранить', ['class' => 'btn btn-lg btn-primary',]) ?></li>
                        </ul>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div><!-- .card-inner -->
        </div><!-- .card-inner-group -->
    </div><!-- .card -->
</div><!-- .nk-block -->
