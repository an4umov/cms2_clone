<?php
/**
 * @var array $block
 * @var integer $index
 * @var boolean $isContent
 * @var boolean $isAjax
 * @var array $expanded
 * @var \common\models\BlockField[] $fields
 * @var $content \common\models\Content
 */

use \common\models\BlockField;
use \backend\components\helpers\IconHelper;
use common\models\ContentBlock;
use \common\components\helpers\BlockHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\helpers\Json;

$data = !empty($block['data']) ? Json::decode($block['data']) : [];
$isDisabled = $block['content_block_type'] === ContentBlock::TYPE_BLOCK_READY || $block['content_block_type'] === ContentBlock::TYPE_FORM;
$panelClass = $isContent ? (!empty($block['content_block_is_active']) ? 'info' : 'danger') : 'info';
$isExpand = !empty($expanded) && is_array($expanded) ? in_array($block['content_block_id'], $expanded) : false;
?>
<div class="panel panel-<?= $panelClass ?> content-block-<?= $block['content_block_id'] ?>">
    <div class="panel-heading">
        <h3 class="panel-title">
            <strong><?= $index ?></strong> // <?= $block['name'] ?> <span class="badge"><?= $block['content_block_type'] === ContentBlock::TYPE_BLOCK ? BlockHelper::getBlockTypeTitle($block['type']) : ($block['content_block_type'] === ContentBlock::TYPE_BLOCK_READY ? BlockHelper::getBlockTypeTitle(ContentBlock::TYPE_BLOCK_READY) : BlockHelper::getBlockTypeTitle(ContentBlock::TYPE_FORM)) ?></span>
            <span class="tools pull-right">
                <a class="fa fa-chevron-<?= $isExpand ? 'down' : 'up' ?>" href="javascript:;" data-id="<?= $block['content_block_id'] ?>" data-type="<?= $block['content_block_type'] ?>"></a>
            </span>
        </h3>
    </div>
    <div class="panel-body"  style="display: <?= $isExpand ? 'block' : 'none' ?>;">
        <? if ($isContent): ?>
            <?= Html::hiddenInput(
                'expanded['.$block['content_block_id'].']',
                0,
                ['id' => 'block-field-expanded-'.$block['content_block_type'].'-'.$block['content_block_id'],]
            )
            ?>
            <? if ($block['content_block_type'] === ContentBlock::TYPE_BLOCK): ?>
            <?
            $colsHtml = $rowHtml = [];
            $colsHtml[] = '<div class="form-group block-field-is_active">
                <label class="control-label" for="block-field-is_active-'.$block['content_block_id'].'" style="display: block;">Активен</label>
                '.CheckboxX::widget([
                    'name' => 'Content[content_blocks_list]['.$block['content_block_id'].'][blocks_list]['.$block['id'].'][is_active]',
                    'value' => $block['content_block_is_active'],
                    'options' => ['class' => 'form-control', 'id' => 'block-field-is_active-'.$block['content_block_id'],],
                    'pluginOptions' => ['threeState' => false,],
                ]).'
            </div>';
            $colsHtml[] = '<div class="form-group block-field-sort">
                <label class="control-label" for="block-field-10">Сортировка</label>
                <input style="width: 140px;" type="number" id="block-field-sort-'.$block['content_block_type'].'-'.$block['content_block_id'].'-'.$block['id'].'" class="form-control" name="Content[content_blocks_list]['.$block['content_block_id'].'][blocks_list]['.$block['id'].'][sort]" value="'.$block['content_block_sort'].'" aria-required="true" placeholder="Сортировка">
            </div>';

            foreach ($fields as $field) {
                $html = BlockHelper::generateBlockField($block['content_block_id'], $block, $field, $data, 0, $content);

                if (in_array($field->type, [BlockField::TYPE_TEXTAREA, BlockField::TYPE_TEXTAREA_EXT, BlockField::TYPE_GRADIENT_COLOR, BlockField::TYPE_LIST, BlockField::TYPE_IMAGE, BlockField::TYPE_STRUCTURE_ID,])) {
                    $rowHtml[] = $html;
                } else {
                    $colsHtml[] = $html;
                }
            }

            $index = 0;
            while ($index < count($colsHtml)) {
                $items = array_slice($colsHtml, $index, 4);

                $cnt = count($items);
                $col = 12 / $cnt;

                echo '<div class="row">'.PHP_EOL;
                foreach ($items as $item) {
                    echo '<div class="col-lg-'.$col.' col-xl-'.$col.'">'.$item.'</div>'.PHP_EOL;
                }
                echo '</div>'.PHP_EOL;

                $index += 4;
            }

            foreach ($rowHtml as $item) {
                echo '<div class="row">'.PHP_EOL;
                echo '<div class="col-lg-12 col-xl-12">'.$item.'</div>'.PHP_EOL;
                echo '</div>'.PHP_EOL;
            }

            ?>
            <? elseif ($block['content_block_type'] === ContentBlock::TYPE_BLOCK_READY): ?>
                <div class="jumbotron jumbotron-fluid" style="padding: 10px;">
                    <div class="container">
                        <h1 class="display-4">Готовый блок</h1>
                        <p class="lead">Содержимое данного блока можно менять лишь в <a href="/blocks/ready/update?id=<?= $block['id'] ?>" target="_blank"><?= IconHelper::getSpanIcon(IconHelper::ICON_READY) ?> соответствующем разделе</a></p>
                    </div>
                </div>
            <? elseif ($block['content_block_type'] === ContentBlock::TYPE_FORM): ?>
                <div class="jumbotron jumbotron-fluid" style="padding: 10px;">
                    <div class="container">
                        <h1 class="display-4">Форма</h1>
                        <p class="lead">Содержимое данного блока можно менять лишь в <a href="/form/form/update?id=<?= $block['id'] ?>" target="_blank"><?= IconHelper::getSpanIcon(IconHelper::ICON_FORM) ?> соответствующем разделе</a></p>
                    </div>
                </div>
            <? endif; ?>
        <? else: ?>
            <? foreach ($fields as $field): ?>
                <?
                if ($isAjax && $field->type === BlockField::TYPE_TEXTAREA_EXT) {
                    $field->type = BlockField::TYPE_TEXTAREA;
                }
                ?>
                <?= BlockHelper::generateBlockField($block['content_block_id'], $block, $field, $data, 0, $content) ?>
            <? endforeach; ?>
        <? endif; ?>

        <div class="form-group pull-right" style="margin-bottom: 0;">
            <? if ($block['content_block_type'] === ContentBlock::TYPE_BLOCK): ?>
                <? if (!$isAjax): ?>
                    <?= Html::button('<i class="'.\backend\components\helpers\IconHelper::ICON_READY.'"></i> "Приготовить" блок', ['title' => 'Копирование данного блока в "Готовые" блоки со всеми данными', 'class' => 'btn btn-primary content-block-ready-btn', 'data-id' => $block['content_block_id'],]) ?>
                <? endif; ?>
                <?= Html::button('<i class="fas fa-trash-alt"></i> Удалить блок', ['class' => 'btn btn-danger content-block-delete-btn', 'data-id' => $block['content_block_id'],]) ?>
            <? endif; ?>
        </div>
    </div>
</div>