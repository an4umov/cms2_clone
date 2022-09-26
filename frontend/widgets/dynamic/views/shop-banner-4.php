<?php


/* @var $banner \common\models\ShopBanner */

$background = !empty($banner->color) ? "background: $banner->color" : '';

?>
<div class="container mycontainer">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
            <div class="shop1">
                <div class="block1 shop_color1" style="<?php echo $background ?>">
                    <h3><?php echo $banner->title ?></h3>
                    <?php echo $banner->description ?>
                </div>
                <div class="block2">
                    <img src="<?php echo $banner->background->fullPath ?>" alt="<?php echo $banner->title ?>" style="max-height: 100px">
                    <h4>RANGE ROVER SPORT NEW L494</h4>
                    <ul class="ul1">
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                        <li><a href="">Land Rover 1</a></li>
                    </ul>
                </div>
                <div class="block3 align-bottom">
                    <h4>RANGE ROVER SPORT NEW L494</h4>
                    <ul class="ul1">
                        <li><a href="">Запчасти Land Rover</a></li>
                        <li><a href="">Запчасти Land Rover</a></li>
                        <li><a href="">Запчасти Land Rover</a></li>
                        <li><a href="">Запчасти Land Rover</a></li>
                        <li><a href="">Запчасти Land Rover</a></li>
                    </ul>
                </div>
                <div class="block4">
                    <img src="<?php echo $banner->background->fullPath ?>" alt="<?php echo $banner->title ?>" style="max-height: 100px">
                    <div class="text">
                        <?php echo $banner->description ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



