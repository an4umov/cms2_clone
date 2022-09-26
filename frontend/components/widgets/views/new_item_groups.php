<?php
/**
 * @var $this yii\web\View
 * @var array $rows
 */

use yii\helpers\Url;


?>
<? if ($rows): ?>
<section class="model-auto" style="margin-top: 10px">
    <div class="model-auto__model" style="display: block;">
        <div class="model-auto__model-title">НОВЫЕ ГРУППЫ ТОВАРОВ</div>
        <ul class="model-auto__model-list">
            <? foreach ($rows as $row): ?>
                <li class="model-auto__model-item"><a href="<?= Url::to(['catalog/view', 'code' => $row['code'],]) ?>" title="<?= $row['title'] ?>"><?= $row['name'] ?></a></li>
            <? endforeach; ?>
        </ul>
    </div>
</section>
<? endif; ?>