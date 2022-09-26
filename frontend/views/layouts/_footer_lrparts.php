<?
/* @var $this \yii\web\View */
/* @var $headerSettings array */
?>
<footer class="footer">
    <?= \frontend\components\widgets\SettingsFooterWidget::widget([]); ?>

    <!-- footer copyright -->
    <div class="footer__copyright">
        <p>© Copyright 2013-<?= date('Y') ?>. All rights is reserved</p>
    </div>
</footer>