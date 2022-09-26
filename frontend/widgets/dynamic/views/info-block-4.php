<?php


/* @var $banner InfoBlock */

use common\models\ContentItem;
use common\models\InfoBlock;

$background = !empty($banner->color) ? "background: $banner->color; opacity: 0.8;" : '';

/** @var ContentItem[] $blocks */
$blocks = $banner->contentItems;

$block_one = null;

if (isset($blocks[0])) {
    $block_one = $blocks[0];
}

$bg = '';
if (!is_null($banner->background)) {
    $bg = "background: url({$banner->background->fullPath}) no-repeat; background-size: cover;";
}

?>
<div class="container mycontainer">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
            <a href="<?php echo $banner->link ?>" class="color_a1">
                <div class="shop1" style="<?php echo $bg; ?>">
                    <?php if (isset($blocks[0])) : ?>
                        <div class="left shop_color1" style="<?php echo $background ?> opacity: 0.8;" ">
                            <?php if (! is_null($blocks[0]->attachedImage->fullPath)) : ?>
                                <img src="<?php echo $blocks[0]->attachedImage->fullPath ?>" alt="<?php echo $blocks[0]->title ?>" style="max-height: 100px">
                            <?php endif; ?>
                            <h3><?php echo $blocks[0]->title ?></h3>
                            <div>
                                <?php echo $blocks[0]->content ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($blocks[1])) : ?>
                        <div class="center-left" style="opacity: 0.8;">
                            <?php if (! is_null($blocks[1]->attachedImage->fullPath)) : ?>
                                <img src="<?php echo $blocks[1]->attachedImage->fullPath ?>" alt="<?php echo $blocks[1]->title ?>" style="max-height: 100px">
                            <?php endif; ?>
                            <h4><?php echo $blocks[1]->title ?></h4>
                            <div>
                                <?php echo $blocks[1]->content ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($blocks[2])) : ?>
                        <div class="center-right align-bottom" style="opacity: 0.85;">
                            <?php if (! is_null($blocks[2]->attachedImage->fullPath)) : ?>
                                <img src="<?php echo $blocks[2]->attachedImage->fullPath ?>" alt="<?php echo $blocks[2]->title ?>" style="max-height: 100px">
                            <?php endif; ?>
                            <h4><?php echo $blocks[2]->title ?></h4>
                            <div>
                                <?php echo $blocks[2]->content ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($blocks[3])) : ?>
                        <div class="right" style="<?php echo $background ?>">
                            <?php if (! is_null($blocks[3]->attachedImage->fullPath)) : ?>
                                <img src="<?php echo $blocks[3]->attachedImage->fullPath ?>" alt="<?php echo $blocks[3]->title ?>" style="max-height: 100px">
                            <?php endif; ?>
                            <h3><?php echo $blocks[3]->title ?></h3>
                            <div>
                                <?php echo $blocks[3]->content ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    </div>
</div>



