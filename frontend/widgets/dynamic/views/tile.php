<?php
/* @var $composite \common\models\Composite */
/* @var $this \yii\web\View */
/* @var $tile \common\models\Tile */
/* @var $contentItem \common\models\ContentItem */

$icons = [
    'fa-balance-scale',
    'fa-bullhorn',
    'fa-business-time',
    'fa-chart-pie',
    'fa-briefcase',
    'fa-edit',
];

$counter = 0;
?>


<section class="blockk6">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-12"><h2><?php echo $tile->title ?></h2></div>

            <?php foreach ( $tile->contentItems as $contentItem ) :?>
            <div class="col-4">
                <div class="sec1"><i class="fas <?php echo $icons[$counter++] ?>"></i></div>
                <div class="sec2">
                    <h4><?php echo $contentItem->title ?></h4>
                    <p><?php echo $contentItem->content ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
