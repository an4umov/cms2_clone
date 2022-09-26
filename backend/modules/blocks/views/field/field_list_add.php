<?php

use common\components\helpers\BlockHelper;

/* @var $this yii\web\View */
/* @var $rows \common\models\BlockFieldList[] */
/* @var $blockID int */
/* @var $contentBlockID int */
/* @var $sort int */

echo BlockHelper::getBlockFieldList($contentBlockID, $blockID, $rows, [], $sort > 0 ? $sort : time());
