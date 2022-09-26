<?php

/* @var $this yii\web\View */
/* @var $model \common\models\UserLk */

$this->title = 'Настройка аккаунта';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
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
                <p>Данные настройки позволят обезопасить ваш аккаунт.</p>
            </div>
        </div>
    </div><!-- .nk-block-head -->
    <div class="card card-bordered">
        <div class="card-inner-group">
            <div class="card-inner">
                <div class="between-center flex-wrap flex-md-nowrap g-3">
                    <div class="nk-block-text">
                        <h6>Изменить пароль</h6>
                        <p>Установите безопасный пароль для защиты вашего аккаунта.</p>
                    </div>
                    <div class="nk-block-actions flex-shrink-sm-0">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                            <li class="order-md-last">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#password-edit">Изменить пароль</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .card-inner -->
        </div><!-- .card-inner-group -->
    </div><!-- .card -->
</div><!-- .nk-block -->
<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="password-edit">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Изменить пароль</h5>
                <ul class="nk-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#password">Пароль</a>
                    </li>
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => false, 'enableClientScript' => false,]); ?>
                    <div class="tab-pane active" id="password">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Новый пароль</label>
                                    <?= $form->field($model, 'newPassword')->passwordInput(['class' => 'form-control form-control-lg',])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Повтор нового пароля</label>
                                    <?= $form->field($model, 'newPasswordConfirm')->passwordInput(['class' => 'form-control form-control-lg',])->label(false) ?>
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
