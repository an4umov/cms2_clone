<?php

/* @var $newsItem  \common\models\Material */

$url = \yii\helpers\Url::to(['content2/material', 'alias' => $newsItem->alias]);
?>


<div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
    <a class="border0" href="<?php echo $url ?>">
        <img src="img/news1.png" alt="">
        <div class="bottom_sec">
            <div class="title"<?php echo $newsItem->title ?>></div>
            <div class="desc"><?php echo $newsItem->readMoreText ?> ...</div>
        </div>
    </a>
</div>
