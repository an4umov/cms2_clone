<?php

/* @var $slider common\models\SliderTile */
/* @var $item common\models\ContentItem */

$count = count($slider->contentItems);

$partsCount = count($slider->contentItems) / 3;

$items = [];

foreach ($slider->contentItems as $item) {
    $items[] = $item;
}

//\yii\helpers\VarDumper::dump($partsCount);exit;

?>

<section class="blockk9" style="background: #254f77">
    <div id="slider2" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

            <?php for ( $i = 0; $i < $partsCount; $i ++ ) : ?>
            <?php $active = $i == 0 ? 'active' : ''; ?>
                <div class="carousel-item <?php echo $active ?>">
                    <div class="container">
                        <div class="row">
                            <?php for ( $j = 0; $j < 3; $j ++ ) : ?>
                                <?php $item = array_shift($items) ?>
                                <div class="col-4 padding0">
                                    <?php if (! is_null($item->attachedImage->fullPath)) : ?>
                                        <img src="<?php echo $item->attachedImage->fullPath ?>" alt="<?php echo $item->title ?>">
                                    <?php endif; ?>
                                    <div class="carousel-caption one d-none d-md-block">
                                        <div class="icon"><i class="fas <?php echo $item->fa_icon ?>"></i></div>
                                        <h5><?php echo $item->title ?></h5>
                                        <div>
                                            <?php echo $item->content ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <a class="carousel-control-prev" href="#slider2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#slider2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
