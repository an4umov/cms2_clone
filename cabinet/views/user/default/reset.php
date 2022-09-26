<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\User $user
 * @var bool $success
 * @var bool $invalidToken
 */

$this->title = 'Сброс пароля';
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h5 class="nk-block-title"><?= $this->title ?></h5>
        <div class="nk-block-des">
            <p>Для сброса текущего пароля укажите новый.</p>
        </div>
    </div>
</div>
<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-icon">
        <em class="icon ni ni-check-circle"></em> Пароль успешно обновлен
    </div>
    <p><?= Html::a('Авторизация', ["/user/login"]) ?></p>
<?php elseif (!empty($invalidToken)): ?>
    <div class="alert alert-danger alert-icon">
        <em class="icon ni ni-cross-circle"></em> <strong>Ошибка</strong>! Неправильный токен.
    </div>
<?php else: ?>
    <?php $form = ActiveForm::begin(['id' => 'reset-form', 'enableClientValidation' => true,]); ?>
    <div class="form-group">
        <div class="alert alert-info alert-icon">
            <em class="icon ni ni-alert-circle"></em> <strong>Email</strong>: <?= $user->email ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($user, 'newPassword', ['class' => 'form-label', 'for' => 'reset-form-newPassword',]) ?>
        <div class="form-control-wrap">
            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="reset-form-newPassword">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <?= Html::activeInput('password', $user, 'newPassword', ['id' => 'reset-form-newPassword', 'class' => 'form-control form-control-lg', 'placeholder' => 'Введите новый пароль',]) ?>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" for="reset-form-newPasswordConfirm">Повторите новый пароль</label>
        <div class="form-control-wrap">
            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="reset-form-newPasswordConfirm">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <?= Html::activeInput('password', $user, 'newPasswordConfirm', ['id' => 'reset-form-newPasswordConfirm', 'class' => 'form-control form-control-lg', 'placeholder' => 'Повторите новый пароль',]) ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton('Сбросить', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'reset-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>