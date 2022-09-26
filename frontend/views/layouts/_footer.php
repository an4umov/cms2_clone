<?
/* @var $this \yii\web\View */
/* @var $headerSettings array */
?>
<footer class="footer">
    <!-- footer preambula -->
    <div class="footer__preambula">
        <p>Преамбула футера с какой-то очень интересной информацией</p>
    </div>
    <!-- footer social -->
    <ul class="footer__social-list">
        <li class="footer__social-item">
            <a class="footer__social-item--utube" href="https://www.youtube.com/channel/UCqHPG2aeiuyOq6bfVb8QZPA"></a>
        </li>
        <li class="footer__social-item">
            <a class="footer__social-item--vk" href="https://vk.com/"></a>
        </li>
        <li class="footer__social-item">
            <a class="footer__social-item--fbook" href="https://www.facebook.com/"></a>
        </li>
        <li class="footer__social-item">
            <a class="footer__social-item--insta" href="https://www.instagram.com/lr.ru/"></a>
        </li>
    </ul>

    <!-- footer contain container -->
    <div class="footer-contain">
        <!-- footer contacts -->
        <div class="footer__contacts footer-contacts">
            <img class="footer-contacts__logo" src="/img/footer/footer-logo.png" alt="">
            <div class="footer-contacts__tel">
                <a class="footer-contacts__tel--icon-number" href="callto:+74956496060"><?= $headerSettings['phone'] ?></a>
                <a class="footer-contacts__tel--" href="callto:+74956496060"><?= $headerSettings['phone'] ?></a>
            </div>
        </div>
        <!-- footer panel -->
        <div class="footer__panel footer-panel">
            <!-- footer panel list -->
            <ul class="footer-panel__list">
                <li class="footer-panel__item">
                    <a class="footer-panel__item--contact" href="#">Контакты</a>
                </li>
                <li class="footer-panel__item">
                    <a class="footer-panel__item--map" href="#">Схема проезда</a>
                </li>
                <li class="footer-panel__item">
                    <a class="footer-panel__item--clock" href="#">Часы работы</a>
                </li>
            </ul>
            <!-- footer panel buttons -->
            <div class="footer-panel__buttons">
                <a class="footer-panel__button footer-panel__button--call" href="#">
                    звонок
                </a>
                <a class="footer-panel__button footer-panel__button--chat" href="#">
                    онлайн чат
                </a>
                <a class="footer-panel__button footer-panel__button--review" href="#">
                    отзывы и пожелания
                </a>
            </div>
        </div>
    </div>

    <?= \frontend\components\widgets\SettingsFooterWidget::widget([]); ?>

    <!-- footer copyright -->
    <div class="footer__copyright">
        <p>© Copyright 2013-<?= date('Y') ?>. All rights is reserved</p>
    </div>
</footer>