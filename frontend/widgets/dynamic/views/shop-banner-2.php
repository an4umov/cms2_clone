<?php


/* @var $banner \common\models\ShopBanner */

$background = !empty($banner->color) ? "background: $banner->color" : '';

?>
<div class="container mycontainer">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="shop2">
                <div class="block1 shop_color2" style="<?php echo $background ?>">
                    <h3><?php echo $banner->title ?></h3>
                    <?php echo $banner->description ?>
                </div>
                <div class="block2">
                    <img src="<?php echo $banner->background->fullPath ?>" alt="<?php echo $banner->title ?>" style="max-height: 100px">
                    <h4>RANGE ROVER SPORT NEW L494</h4>
                    <ul class="ul2">
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>