<?php

use common\components\helpers\CatalogHelper;
use common\models\SpecialOffers;
use \yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var array $rows
 */
?>
<? if ($rows): ?>
<div class="single-offer-vendor-page__pdf-section single-vendor-pdf">
    <? foreach ($rows as $row): ?>
        <div class="single-vendor-pdf__block">
            <a href="<?= $row['url'] ?>">
                <div class="vendor-pdf-block__text"><?= $row['description'] ?></div>
            </a>
        </div>
    <? endforeach; ?>
</div>
<? endif; ?>
