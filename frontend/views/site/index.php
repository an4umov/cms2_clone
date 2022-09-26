<?php
use \common\components\helpers\ContentHelper;
use common\models\Block;
use common\models\BlockReady;
use common\models\ContentBlock;
use frontend\components\widgets\LastNewsWidget;

/* @var \yii\web\View $this */
/* @var \common\models\Content $indexPage */
/* @var string $title */

$this->title = $title;

if ($indexPage) {
    $indexPage->incViewsCount();

    $blocks = [];
    $rows = $indexPage->getBlocksData();
    foreach ($rows as $row) {
        if (!empty($row['content_block_is_active'])) {
            $model = ($row['content_block_type'] === ContentBlock::TYPE_BLOCK) ? new Block() : new BlockReady();
            $model->setAttributes($row, false);
            $model->data = $row['data'];
            $model->content_block_id = $row['content_block_id'];
            $model->content_block_type = $row['content_block_type'];
            $model->content_block_sort = $row['content_block_sort'];

            $blocks[] = $model;
        }
    }

    foreach ($blocks as $block) {
        echo ContentHelper::renderBlockByGlobalType($block, ContentHelper::getBlockJson($block), false);
    }
}