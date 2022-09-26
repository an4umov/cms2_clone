<?php

/**
 * @var \yii\web\View $this
 * @var string $title
 * @var array $settings
 * @var array $data
 */

use common\components\helpers\CatalogHelper;
use \common\models\SettingsMainShopLevel;
use yii\helpers\Url;

$this->title = $title;
?>
<section class="departaments">
    <? foreach ($data as $type => $settings): ?>
        <? if ($type === SettingsMainShopLevel::TYPE_ONE): ?>
            <? foreach ($settings as $setting): ?>
            <div class="main-departament">
                <div class="main-departament__content">
                    <picture>
                        <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($setting['code']) ?>" alt="">
                    </picture>
                </div>
                <div class="main-departament__info main-dep-info">
                    <div class="main-dep-info__title"><?= $setting['name'] ?></div>
                    <div class="main-dep-info__text"><?= $setting['title'] ?></div>
                    <?= \yii\helpers\Html::a('Смотреть все', ['catalog/view', 'code' => $setting['code'],], ['class' => 'main-dep-info__watch-all-btn',]) ?>
                </div>
            </div>
            <? endforeach; ?>
        <? elseif ($type === SettingsMainShopLevel::TYPE_TWO): ?>
            <? $rows = ceil(count($settings) / 2); ?>

            <? $line = $count = 1; ?>
            <? foreach ($settings as $setting): ?>
                <? if ($line === 1): ?><div class="second-departaments"><? endif; ?>
                <div class="second-departaments__block">
                    <div class="second-departaments__content">
                        <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($setting['code']) ?>" alt="">
                    </div>
                    <div class="second-departaments__info sec-dep-info">
                        <div class="sec-dep-info__title"><?= $setting['name'] ?></div>
                        <div class="sec-dep-info__text"><?= $setting['title'] ?></div>
                        <?= \yii\helpers\Html::a('Смотреть все', ['catalog/view', 'code' => $setting['code'],], ['class' => 'sec-dep-info__watch-all-btn',]) ?>
                    </div>
                </div>
                <? if ($line === 2 || $count == count($settings)): ?></div><? endif; ?>
                <?
                if ($line === 2) {
                    $line = 1;
                } else {
                    $line++;
                }

                $count++;
                ?>
            <? endforeach; ?>
        <? elseif ($type === SettingsMainShopLevel::TYPE_THREE): ?>
            <? $rows = ceil(count($settings) / 3); ?>

            <? $line = $count = 1; ?>
            <? foreach ($settings as $setting): ?>
                <? if ($line === 1): ?><div class="third-departaments"><? endif; ?>
                <div class="third-departaments__block" style="background-color: #307454;">
                    <?= \yii\helpers\Html::beginTag('a',  ['href' => Url::to(['catalog/view', 'code' => $setting['code'],]),]) ?>
                        <div class="third-departaments__info th-dep-info">
                            <div class="th-dep-info__title"><?= $setting['name'] ?></div>
                            <div class="th-dep-info__text"><?= $setting['title'] ?></div>
                        </div>
                        <div class="third-departaments__content">
                            <img src="<?= CatalogHelper::getCatalogTopLevelImageUrl($setting['code']) ?>" alt="">
                        </div>
                    <?= \yii\helpers\Html::endTag('a') ?>
                </div>
                <? if ($line === 3 || $count == count($settings)): ?></div><? endif; ?>
                <?
                if ($line === 3) {
                    $line = 1;
                } else {
                    $line++;
                }

                $count++;
                ?>
                <? endforeach; ?>
        <? endif; ?>
    <? endforeach; ?>
</section>