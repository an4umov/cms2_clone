<?php

/* @var \yii\web\View $this */
/* @var array $page */

$this->title = $page['title']['rendered'];
?>

<div class="page" style="margin: 15px 0;">
    <h1><a href="/wp/<?= $page['slug'] ?>"><?= $page['title']['rendered'] ?></a></h1>
    <p><?= $page['content']['rendered'] ?></p>
</div>


