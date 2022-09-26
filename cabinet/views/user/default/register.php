<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\User $profile
 * @var string $userDisplayName
 */

$this->title = 'Регистрация';
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title"><?= $this->title ?></h4>
        <div class="nk-block-des">
            <p>Создайте новый аккаунт</p>
        </div>
    </div>
</div>
<?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>
    <div class="alert alert-success alert-icon">
        <em class="icon ni ni-check-circle"></em> <?= $flash ?>
    </div>
<?php else: ?>
    <?php $form = ActiveForm::begin(['id' => 'register-form', 'enableClientValidation' => true,]); ?>
        <div class="form-group">
            <?= Html::activeLabel($user, 'email', ['class' => 'form-label', 'for' => 'register-form-email',]) ?>
            <?= Html::activeInput('text', $user, 'email', ['id' => 'register-form-email', 'class' => 'form-control form-control-lg', 'placeholder' => 'Введите адрес электронной почты',]) ?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($user, 'password', ['class' => 'form-label', 'for' => 'register-form-password',]) ?>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch" data-target="register-form-password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <?= Html::activeInput('password', $user, 'newPassword', ['id' => 'register-form-password', 'class' => 'form-control form-control-lg', 'placeholder' => 'Введите пароль',]) ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'register-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="form-note-s2 text-center pt-4">Уже есть аккаунт? <a href="/user/login"><strong>Авторизация</strong></a>
</div>
<?php endif; ?>