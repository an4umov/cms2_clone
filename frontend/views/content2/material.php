<?php

/* @var $this \yii\web\View */
/* @var $material \common\models\Material */

$this->title = $material->title;
$this->registerJsFile('/js/readmore.js', [
    'depends' => ['yii\web\JqueryAsset']
]);


$JS = <<<JS
$('#readmore').readmore({
        maxHeight: 230,
        moreLink: '<div class="readmore"><a href="#">Подробнее <i class="fas fa-angle-double-right"></i></a></div>',
        lessLink: '<div class="readmore"><a href="#">Скрыть <i class="fas fa-angle-double-right"></i></a></div>'
    });
JS;


$this->registerJs($JS, \yii\web\View::POS_READY);
?>

<section class="container mycontainer">
    <div class="row">
        <div class="col">
            <div class="breadcrumb">
                <ul>
                    <li><a href="">Главная</a></li>
                    <li>/</li>
                    <li>Информационная страница</li>
                </ul>
            </div>
            <h1><?php echo $material->title ?></h1>
        </div>
    </div>
</section>

<section class="blockk1">
    <div class="container mycontainer">
        <div class="row">
            <div class="col">
                <img src="img/image1.png" alt="">
                <!--<section id="readmore">-->
                <section>
                    <?php echo $material->content ?>
                </section>
            </div>
        </div>
    </div>
</section>
