<?php
/* @var \yii\web\View $this */
/* @var $blocks SettingsFooter[] */

use \yii\helpers\Html;
use common\models\SettingsFooter;

$columns = 2;
$cnt = count($blocks);
$rows = ceil($cnt / $columns);
$div = $cnt % $columns;
$index = 0;
$rowIndex = 1;
?>

<? for ($i = 0; $i < $rows; $i++): ?>
    <!-- footer information block -->
    <div class="footer__information">
    <? for ($y = 0; $y < $columns; $y++): ?>
        <? if (isset($blocks[$index])): ?>
            <? $block = $blocks[$index]; ?>
            <!-- footer information list -->
            <ul class="footer__information-list">
                <div class="footer__information-title"><?= !empty($block->url) ? Html::a($block->name, $block->url) : $block->name ?></div>
                <? foreach ($block->items as $item): ?>
                    <? if ($item->is_active): ?>
                    <li class="footer__information-item">
                        <?= Html::a($item->name, $item->url) ?>
                    </li>
                    <? endif; ?>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
        <? $index++; ?>
    <? endfor; ?>
    </div>

    <? if ($rowIndex < $rows): ?>
        <div class="footer__information-separator"></div>
    <? endif; ?>

    <? $rowIndex++; ?>
<? endfor; ?>