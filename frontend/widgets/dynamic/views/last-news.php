<?php


/* @var $news  common\models\Material[] */

?>
<section class="latest_news">
    <div class="container mycontainer">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 "><h2>последние новости</h2></div>
        </div>
    </div>


    <div id="carousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container mycontainer latest_news">
                    <div class="row">
                        <?php
                        foreach ( $news as $newsItem )
                            echo $this->render('_last-news-item', [
                                'newsItem' => $newsItem
                            ]);
                        ?>
                    </div>

                </div>
                <div class="readmore"><a href="">смотреть всё <i class="fas fa-angle-double-right"></i></a></div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

