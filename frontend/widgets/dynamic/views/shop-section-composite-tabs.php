<?php

/* @var $composite \common\models\Composite */
/* @var $this \yii\web\View */
/* @var $contentItem \common\models\ContentItem */
/* @var $image \common\models\Image */

?>


<section class="blockk2">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $composite->title ?></h2>
            </div>
            <div class="col">


                    <ul class="nav nav-tabs" role="tablist">
                        <?php $counter = 0; ?>
                        <?php  foreach ( $composite->contentItems as $contentItem ) : ?>
                        <?php $active = $counter++ === 0 ? ' active' : ''; ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active; ?>" href="#<?php echo $contentItem->navId ?>" role="tab" data-toggle="tab"><?php echo $contentItem->title ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <div class="tab-content" >

                    <?php $counter = 0; ?>
                    <?php foreach ( $composite->contentItems as $contentItem ) : ?>
                        <?php $active = $counter++ === 0 ? 'show active' : ''; ?>
                        <div role="tabpanel" class="tab-pane fade <?php echo $active ?>" id="<?php echo $contentItem->navId ?>">
                            <?php echo $contentItem->content ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        $counter = 0;
                        foreach ( $composite->images as $image ) {
                            echo "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"{$counter}\" class=\"active\"></li>";
                            $counter ++;
                        }
                        ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php $counter = 0; ?>
                        <?php foreach ( $composite->images as $image ) : ?>
                        <?php $active = $counter++ === 0 ? ' active' : ''; ?>
                            <div class="carousel-item <?php echo $active; ?>">
                                <img class="d-block w-100" src="<?php echo $image->fullPath ?>" alt="<?php echo $image->img_alt ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>