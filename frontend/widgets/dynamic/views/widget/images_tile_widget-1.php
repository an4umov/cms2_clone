<?php

/* @var $this yii\web\View */
/* @var $item common\models\Widget */
/* @var $contentItem \common\models\ContentItem */

?>
<section class="blockk12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $item->title ?></h2>
                <h3><?php echo $item->description ?></h3>
            </div>


            <section class="gallery-block compact-gallery">
                <div class="container">
                    <div class="row no-gutters">
                        <?php foreach ($item->contentItems as $contentItem) : ?>
                            <?php if (! is_null($contentItem->attachedImage->fullPath)) : ?>
                                <div class="col-md-6 col-lg-2 item zoom-on-hover">
                                    <a class="lightbox" href="<?php echo $contentItem->attachedImage->fullPath ?>">
                                        <img class="img-fluid image" src="<?php echo $contentItem->attachedImage->fullPath ?>">
                                        <span class="description">
                                    <span class="description-heading"><?php echo $contentItem->title ?></span>
                                        </span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>


