<?php


/* @var $banner \common\models\LowBanner */

$background = ! is_null($banner->background) ? "url({$banner->background->fullPath})" : $banner->color;

?>

<div class="sales_baner" style="background: <?php echo $background ?>">
    <a href="<?php echo $banner->link ?>">
        <div class="text1"><?php echo $banner->title ?></div>
        <div class="text2"><?php echo $banner->text ?></div>
    </a>
</div>



