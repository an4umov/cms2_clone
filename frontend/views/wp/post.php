<?php

/* @var \yii\web\View $this */
/* @var array $post */

$this->title = $post['title']['rendered'];
?>

<div class="post" style="margin: 15px 0;">
    <h1><a href="/wp/<?= $post['id'] ?>"><?= $post['title']['rendered'] ?></a></h1>
    <p><?= $post['content']['rendered'] ?></p>
</div>


