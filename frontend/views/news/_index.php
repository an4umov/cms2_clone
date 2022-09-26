<?php

/* @var \yii\web\View $this */
/* @var $model common\models\News */

$description = $model->getDecodedDescription();
?>
<div class="blockk1">
    <div class="container mycontainer">
        <div class="row">
            <div class="col">
                <h3><a href="/news/<?= $model->id ?>"><?= $model->title ?></a></h3>
                <section>
                    <p><?= $description['text'] ?? '' ?></p>
                </section>
            </div>
        </div>
    </div>
</div>