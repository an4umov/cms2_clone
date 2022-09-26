<?php
/* @var \yii\web\View $this */
/* @var $departments array */
/* @var $trees array */
/* @var $groupTitle string */
/* @var $group string */

use common\components\helpers\CatalogHelper;
use yii\helpers\Url; ?>

<? if ($departments): ?>
<div class="model-auto__generation-watched_earlier" style="display: block;">
    <div class="model-auto__generation-title">Вы смотрели ранее</div>
    <ul class="model-auto__generation-list">
        <? foreach ($departments as $department): ?>
            <li class="model-auto__generation-item">
                <?
                $url = ['shop/shop', 'shop' => $department['url'],];
                if (!empty($group)) {
                    $url['group'] = $group;
                }
                ?>
                <a href="<?= Url::to($url) ?>" data-code="<?= $department['catalog_code'] ?>">
                    <div class="model-auto__generation-item-picture">
                        <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($department['catalog_code']) ?>" alt="<?= $department['catalog_code'] ?>">
                    </div>
                    <div class="model-auto__generation-item-text">
                        <?= $department['name'] ?>
                        <?= CatalogHelper::renderTagForLinkCounter($groupTitle, $department, CatalogHelper::COUNTER_TYPE_GENERATION); ?>
                    </div>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</div>
<? endif; ?>