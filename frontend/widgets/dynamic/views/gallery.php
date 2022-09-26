<?php

/* @var $gallery Gallery */

use common\models\ContentItem;
use core\models\Gallery;
use yii\helpers\Html;

$ID = uniqid('gallery_') . '_' . $gallery->id;
$labels = '';
$images = '';


$counter = 0;
//foreach ($gallery->images as $image) {
//    $labels .= \yii\helpers\Html::tag('li', '', [
//        'class' => $counter === 0 ? 'active' : '',
//        'data-target' => $ID,
//        'data-slide-to' => $counter
//    ]);
//
//    $activeImage = $counter === 0 ? ' active' : '';
//    $img = \yii\helpers\Html::img($image, [ 'class' => 'd-block w-100' ]);
//    $images .= \yii\helpers\Html::tag('div', $img, [ 'class' => 'carousel-item' . $activeImage, 'style' => 'max-height: 480px' ]);
//
//    $counter ++;
//}
//
//$labelsList = \yii\helpers\Html::tag('ol', $labels, ['class' => 'carousel-indicators']);

/** @var ContentItem $item */
//foreach ($gallery->items as $item) {
//    $labels .= Html::tag('li', '', [
//        'class' => $counter === 0 ? 'active' : '',
//        'data-target' => $ID,
//        'data-slide-to' => $counter
//    ]);
//
//    $activeImage = $counter === 0 ? ' active' : '';
//    $img = Html::img($item->attachedImage->fullPath, [ 'class' => 'd-block w-100' ]);
//    $images .= Html::tag('div', $img, [ 'class' => 'carousel-item' . $activeImage, 'style' => 'max-height: 480px' ]);
//
//    $counter ++;
//}


foreach ($gallery->items as $item) {
    $labels .= Html::tag('li', '', [
        'class' => $counter === 0 ? 'active' : '',
        'data-target' => $ID,
        'data-slide-to' => $counter
    ]);

    $activeImage = $counter === 0 ? ' active' : '';
    $img = Html::img($item->attachedImage->fullPath, [ 'class' => 'd-block w-100' ]);
    $caption =  Html::tag('div', "<div class=\"carousel-caption d-none d-md-block\">
            <h5>$item->title;</h5>
            <p>$item->content;</p>
        </div>");
    $images .= Html::tag('div', $caption . $img, [ 'class' => 'carousel-item' . $activeImage, 'style' => 'max-height: 480px' ]);

    $counter ++;
}

$labelsList = Html::tag('ol', $labels, ['class' => 'carousel-indicators']);
//
//\yii\helpers\VarDumper::dump($images, 3, 1);exit;

?>


<div id="<?php echo $ID; ?>" class="carousel slide slider_main" data-ride="carousel">
    <?php echo $labelsList; ?>
    <div class="carousel-inner">
        <!--<div class="carousel-caption d-none d-md-block">
            <h5><?php /*echo $gallery->title; */?></h5>
            <p><?php /*echo $gallery->description; */?></p>
        </div>-->
        <?php echo $images; ?>
    </div>
    <a class="carousel-control-prev" href="#<?php echo $ID; ?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#<?php echo $ID; ?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


