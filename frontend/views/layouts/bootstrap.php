<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php echo Html::csrfMetaTags() ?>

    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="preload" href="/font/opensans.woff2" as="font" crossorigin>
    <link rel="preload" href="/font/opensansbold.woff2" as="font" crossorigin>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/offcanvas.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php $this->beginBody() ?>
<div class="container">
    <main>
        <div class="text-center">
            <h2><?php echo Html::encode($this->title) ?></h2>
        </div>
        <div class="row g-5">
            <div class="col-md-12">
                <?= \common\widgets\Alert::widget(['isBackend' => false, 'view' => $this,]) ?>
                <? Yii::$app->session->removeAllFlashes() ?>
                <?= $content ?>
            </div>
        </div>
    </main>
    <footer class="my-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017–<?= date('Y') ?> LR.RU</p>
        <ul class="list-inline">
            <li class="list-inline-item">Тестовая страница</li>
        </ul>
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
