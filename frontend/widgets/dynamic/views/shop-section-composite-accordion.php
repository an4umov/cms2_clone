<?php

/* @var $composite \common\models\Composite */
/* @var $this \yii\web\View */
/* @var $contentItem \common\models\ContentItem */
/* @var $image \common\models\Image */

?>

<section class="blockk5">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-12"><h2><?php echo $composite->title ?></h2>
                <h3><?php echo $composite->description ?></h3>
            </div>
            <div class="col">
                <div class="wrapper center-block">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php $counter = 0; ?>
                        <?php  foreach ( $composite->contentItems as $contentItem ) : ?>
                            <?php $active = $counter++ === 0 ? ' active' : ''; ?>

                            <div class="panel panel-default">

                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $contentItem->navId ?>">
                                            <?php echo $contentItem->title ?>
                                        </a>
                                    </h4>
                                </div>

                                <div id="<?php echo $contentItem->navId ?>" class="panel-collapse collapse" role="tabpanel">
                                    <div class="panel-body">
                                        <?php echo $contentItem->content ?>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col id=" slider
            ">
            <div id="myCarousel1" class="carousel slide">
                <!-- main slider carousel items -->
                <div class="carousel-inner">

                    <?php $counter = 0; ?>
                    <?php foreach ( $composite->images as $image ) : ?>
                        <?php $active = $counter === 0 ? ' active' : ''; ?>
                        <div class="<?php echo $active; ?> item carousel-item" data-slide-number="<?php echo $counter; ?>">
                            <img src="<?php echo $image->fullPath ?>" alt="<?php echo $image->img_alt ?>" class="img-fluid">
                        </div>
                    <?php $counter ++; ?>
                    <?php endforeach; ?>


                    <!-- <a class="carousel-control left pt-3" href="#myCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                     <a class="carousel-control right pt-3" href="#myCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></a> -->

                </div>
                <!-- main slider carousel nav controls -->

                <ul class="carousel-indicators list-inline">
                    <?php $counter = 0; ?>
                    <?php foreach ( $composite->images as $image ) : ?>
                        <?php $active = $counter === 0 ? ' active' : ''; ?>
                        <li class="list-inline-item <?php echo $active; ?>">
                            <a id="carousel-selector-<?php echo $counter; ?>" class="selected" data-slide-to="<?php echo $counter; ?>" data-target="#myCarousel1">
                                <img src="<?php echo $image->fullPath ?>" alt="<?php echo $image->img_alt ?>" class="img-fluid">
                            </a>
                        </li>
                        <?php $counter ++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
