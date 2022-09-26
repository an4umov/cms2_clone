<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\ForgotForm $model
 */

$this->title = 'Забыли пароль?';
?>
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h5 class="nk-block-title"><?= $this->title ?></h5>
        <div class="nk-block-des">
            <p>Для восстановления пароля укажите ниже ваш адрес электронной почты.</p>
        </div>
    </div>
</div>
<?php if ($flash = Yii::$app->session->getFlash('Forgot-success')): ?>
    <div class="alert alert-success alert-icon">
        <em class="icon ni ni-check-circle"></em> <?= $flash ?>
    </div>
<?php else: ?>
    <?php $form = ActiveForm::begin(['id' => 'forgot-form', 'enableClientValidation' => true,]); ?>
        <div class="form-group">
            <div class="form-label-group">
                <?= Html::activeLabel($model, 'email', ['class' => 'form-label', 'for' => 'forgot-form-email',]) ?>
            </div>
            <?= Html::activeInput('text', $model, 'email', ['id' => 'forgot-form-email', 'class' => 'form-control form-control-lg', 'placeholder' => 'Введите адрес электронной почты',]) ?>
        </div>
        <div class="form-group">
            <?php echo Html::submitButton('Отправить', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'forgot-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="form-note-s2 text-center pt-4">
        <a href="/user/login"><strong>Вернуться к авторизации</strong></a>
    </div>
<?php endif; ?>