<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use yii\helpers\Html;
use yii\helpers\Json;

if ($exception->statusCode === 404) {
    $this->title = 'Страница не найдена';
} else {
    $this->title = 'Ошибка сервера';
}
$this->params['breadcrumbs'][] = ['label' => \frontend\controllers\LrPartsController::BREADCRUMB_NAME, 'url' => ['/',],];
?>
<? if ($exception->statusCode === 404): ?>
<?
    $formModel = new \frontend\models\SendNotFoundForm();
    $cookieValue = AppHelper::getCookieValue(CatalogHelper::COOKIE_LRPARTS_SEARCH);
    $searchResults = Json::decode($cookieValue);
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
            <?= Html::hiddenInput('SendNotFoundForm[type]', \frontend\models\SendNotFoundForm::TYPE_LRPARTS) ?>
            <div class="notfound-page-form__title">Ничего не нашлось?</div>
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

    <? if ($searchResults): ?>
    <!-- page title -->
    <section class="catalog-search-recent">
        <h2>Недавние запросы</h2>
        <ul>
            <? foreach ($searchResults as $code => $data): ?>
                <li>
                    <a href="<?= \yii\helpers\Url::to(['lr-parts/view', 'id' => $data['rubric_id'],]) ?>"><b><?= $code ?></b> <?= $data['name'] ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    </section>
    <? endif; ?>
</section>
<? else: ?>
    <section class="servererror-page">
        <div class="servererror-page__wrapper">
            <!-- description -->
            <div class="servererror-page__description">
                <div class="servererror-page__500-bg"></div>
                <div class="servererror-page__title">Ошибка сервера</div>
                <p class="servererror-page__text">По техническим причинам в данный момент работа с сайтом недоступна. </p>
                <p class="servererror-page__text">Попробуйте повторить ваши действия позже</p>
                <a href="/" class="servererror-page__btn">Вернуться на главную</a>
            </div>
            <!-- art -->
            <div class="servererror-page__art-bg"></div>
        </div>
    </section>
<? endif; ?>
