<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Авторизация';
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title"><?= $this->title ?></h4>
        <div class="nk-block-des">
            <p>Войдите в панель личного кабинета, используя свой адрес электронной почты и пароль</p>
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false,]); ?>
    <div class="form-group">
        <div class="form-label-group">
            <?= Html::activeLabel($model, 'email', ['class' => 'form-label',]) ?>
        </div>
        <?= Html::activeInput('text', $model, 'email', ['class' => 'form-control form-control-lg', 'placeholder' => 'Введите адрес электронной почты',]) ?>
    </div>
    <div class="form-group">
        <div class="form-label-group">
            <?= Html::activeLabel($model, 'password', ['class' => 'form-label',]) ?>
            <a class="link link-primary link-sm" href="/user/forgot">Забыли пароль?</a>
        </div>
        <div class="form-control-wrap">
            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="login-password">
                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
            </a>
            <?= Html::activeInput('password', $model, 'password', [ 'id' => 'login-password', 'class' => 'form-control form-control-lg', 'placeholder' => 'Введите пароль',]) ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton('Вход', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<div class="form-note-s2 text-center pt-4"> Впервые здесь? <a href="/user/register">Создать аккаунт</a></div>