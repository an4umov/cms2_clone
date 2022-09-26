<?php

/* @var \yii\web\View $this */
/* @var array $posts */

$this->title = 'Записи WP';
?>

<? foreach ($posts as $post): ?>
<div class="post" style="margin: 15px 0;">
    <h1><a href="/wp/<?= $post['id'] ?>"><?= $post['title']['rendered'] ?></a></h1>
    <p><?= $post['content']['rendered'] ?></p>
</div>
<? endforeach; ?>


