<?php
use common\components\helpers\CatalogHelper;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var $models array
 */

$class = $isPage ? 'offers-vendor-catalog-mobile' : 'offers-catalog-mobile';
?>

<br><br>
<?//= \yii\helpers\Html::a('Очистить', \yii\helpers\Url::to('favorite/clear')) ?>

<? if (empty($data)): ?>
    <!-- Блок с информацией об отсутствии товарных предложений -->
    <div class="single-offer-vendor-page__no-offers-info no-offers-info">
        <div class="no-offers-info__content">
            <div class="no-offers-info__first-paragraph">
                <img class="no-offers-info__picture" src="/img/offers/no-offers-info-pic.png" alt="no-offers">
                <p>В избранном пока ничего нет</p>
            </div>
            <div class="no-offers-info__second-paragraph">
                кликайте по сердечку в<a class="send-offer-request" href="/models">каталоге</a>
            </div>
        </div>
        <div class="no-offers-info__shadow"></div>
    </div>
<? else: ?>

    <section class="<?= $class ?>">
        <? if ($isPage): ?>
            <?= Html::tag('h2', $title, ['class' => 'offers-vendor-catalog-mobile__title',]) ?>
        <? else: ?>
            <?= Html::tag('h1', $title) ?>
        <? endif; ?>
        <? foreach ($data as $item): ?>
            <? if ($isPage): ?>
                <?= CatalogHelper::getCardProductMobilePageHtml($item) ?>
            <? else: ?>
                <?= CatalogHelper::getCardProductMobileHtml($item) ?>
            <? endif; ?>
        <? endforeach; ?>
    </section>
    <? $class = $isPage ? 'offers-vendor-catalog-desktop' : 'offers-catalog-desktop'; ?>
    <section class="<?= $class ?>">
        <? if (!$isPage): ?>
        <div class="offers-catalog-desktop__help">
            Кликнув по карточке товарного предложения можно перейти на страницу артикула
            <button class="offerCardDesktopHelpBtn">Понятно</button>
        </div>
        <? endif; ?>
        <div class="favorite-to-mail-form__wrapper">
            <?= Html::beginTag('form', ['class' => 'favorite-to-mail-form']) ?>
            <?= Html::input('email', 'email', '',['placeholder' => 'Введите email', 'class' => 'favorite-to-mail-form__input'],) ?>
            <?= Html::beginTag('div', ['class' => 'favorite-to-mail-form__button']) ?>Отправить<?= Html::endTag('div') ?>
            <?= Html::beginTag('div', ['class' => 'favorite-to-mail-form__helper']) ?>Отправить список Избранного на почту<?= Html::endTag('div') ?>
            <?= Html::endTag('form') ?>
        </div>
        <? if ($isPage): ?>
            <?= Html::tag('h2', $title, ['class' => 'offers-vendor-catalog-desktop__title',]) ?>
        <? else: ?>
            <?= Html::tag('h1', $title) ?>
        <? endif; ?>
        <? 
        foreach ($data as $item): ?>
            <? if ($isPage): ?>
                <?= CatalogHelper::getCardProductDesktopPageHtml($item) ?>
            <? else: ?>
                <?= CatalogHelper::getCardProductDesktopHtml($item) ?>
            <? endif; ?>
        <? endforeach; ?>
        <? if(count($data) > 5) { ?>
        <br>
        <br>
        <div class="favorite-to-mail-form__wrapper">
            <?= Html::beginTag('form', ['class' => 'favorite-to-mail-form']) ?>
            <?= Html::input('email', 'email', '',['placeholder' => 'Введите email', 'class' => 'favorite-to-mail-form__input'],) ?>
            <?= Html::beginTag('div', ['class' => 'favorite-to-mail-form__button']) ?>Отправить<?= Html::endTag('div') ?>
            <?= Html::beginTag('div', ['class' => 'favorite-to-mail-form__helper']) ?>Отправить список Избранного на почту<?= Html::endTag('div') ?>
            <?= Html::endTag('form') ?>
        </div>
        <br>
        <br>
        <br>
        <? } ?>
    </section>
    <br>
    <br>
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
<? endif; ?>
