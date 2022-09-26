<?php

/* @var $this yii\web\View */
/* @var $item common\models\Widget */
/* @var $contentItem \common\models\ContentItem */

$groupSize = 7;
$groupsCount = count($item->contentItems) / $groupSize;
$groupsCountRest = count($item->contentItems) % $groupSize;

if ($groupsCountRest > 0) {
    $groupsCount += 1;
}

$items = $item->contentItems;
?>


<section class="blockk13">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $item->title ?></h2>
                <h3><?php echo $item->description ?></h3>
            </div>

            <div class="product-slider">
                <?php $id = uniqid('_'.$item->id) ?>
                <div id="<?php echo $id ?>" class="carousel slide" data-ride="<?php echo $id ?>">
                    <div class="carousel-inner">
                        <?php foreach ($item->contentItems as $contentItem) : ?>
                            <?php if (! is_null($contentItem->attachedImage->fullPath)) : ?>
                                <div class="carousel-item">
                                    <img class="img-fluid image" src="<?php echo $contentItem->attachedImage->fullPath ?>">
                                    <div class="carousel-caption">
                                        <?php echo $contentItem->title ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="clearfix">
                    <?php $id = $id . '-thumbcarousel'; ?>
                    <div id="<?php echo $id ?>" class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            <?php for ($i = 0; $i < $groupsCount; $i ++ ): ?>
                            <div class="carousel-item active">
                                <?php for ($j = 0; $j < $groupSize; $j ++ ): ?>
                                <?php
                                    $contentItem = array_shift($item->contentItems);
                                    ?>
                                    <div data-target="#carousel" data-slide-to="<?php echo $j ?>" class="thumb">
                                        <img class="img-fluid image" src="<?php echo $contentItem->attachedImage->fullPath ?>">
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <!-- /carousel-inner -->

                        <a class="left carousel-control-prev" href="#<?php echo $id ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Назад</span>
                        </a>
                        <a class="left carousel-control-next" href="#<?php echo $id ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Вперед</span>
                        </a>
                        <!-- /thumbcarousel -->

                    </div>
                </div>

            </div>


        </div>
    </div>
</section>

