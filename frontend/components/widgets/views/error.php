<?php 
    use yii\helpers\Html;
    $formModel = new \frontend\models\SendNotFoundForm();
?>

<section class="notfound-page">
    <div class="notfound-page__form-wrapper">
        <div class="notfound-page__404-bg"></div>
            <?php $form = \yii\widgets\ActiveForm::begin([
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'method' => 'post',
                'action' => \yii\helpers\Url::to(['/form/send-not-found',]),
                'options' => ['class' => 'notfound-page__form notfound-page-form',],
            ]); ?>
            <?= Html::hiddenInput('SendNotFoundForm[type]', \frontend\models\SendNotFoundForm::TYPE_SITE) ?>
            <div class="notfound-page-form__title">
                <?php
                    if ($text) {
                        echo '<p style="color: red;">'.$text.'</p>';
                    } else {
                        echo "Ничего не нашлось?";
                    }
                ?>
            </div>
            <div class="notfound-page-form__subtitle">Воспользуйтесь <span>бесплатной</span> консультацией по подбору запчастей!
            </div>
            <ul class="notfound-page-form__inner">
                <li class="notfound-page-form__input">
                    <label class="notfound-page-form__input-title"><?= $formModel->getAttributeLabel('brand') ?></label>
                    <?= Html::activeTextInput($formModel, 'brand', ['class' => 'notfound-page-form__input-field', 'placeholder' => 'Введите марку, год, время в экспулатации и тд.',]) ?>
                </li>
                <li class="notfound-page-form__input">
                    <label class="notfound-page-form__input-title"><?= $formModel->getAttributeLabel('part') ?></label>
                    <?= Html::activeTextInput($formModel, 'part', ['class' => 'notfound-page-form__input-field', 'placeholder' => 'Введите номер или название одной или нескольких запчастей',]) ?>
                </li>
                <li class="notfound-page-form__input">
                    <label class="notfound-page-form__input-title"><?= $formModel->getAttributeLabel('name') ?></label>
                    <?= Html::activeTextInput($formModel, 'name', ['class' => 'notfound-page-form__input-field', 'placeholder' => 'Введите Ваше имя',]) ?>
                </li>
                <li class="notfound-page-form__input">
                    <label class="notfound-page-form__input-title"><?= $formModel->getAttributeLabel('email') ?></label>
                    <?= Html::activeTextInput($formModel, 'email', ['class' => 'notfound-page-form__input-field', 'placeholder' => 'Введите email',]) ?>
                </li>
                <li class="notfound-page-form__input">
                    <label class="notfound-page-form__input-title"><?= $formModel->getAttributeLabel('phone') ?></label>
                    <?= Html::activeTextInput($formModel, 'phone', ['class' => 'notfound-page-form__input-field', 'placeholder' => 'Введите номер телефона',]) ?>
                </li>
            </ul>
            <div class="notfound-page-form__btns-wrapper">
                <?= Html::submitButton('отправить запрос', ['class' => 'notfound-page-form__submit-btn',]) ?>
                <a href="/" class="notfound-page-form__secondary-btn">вернуться на главную</a>
            </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
        <div class="notfound-page__art-bg"></div>
    </div>
</section>