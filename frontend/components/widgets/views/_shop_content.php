<?php

use \yii\helpers\Html;
use \common\models\Content;
use \common\models\Block;
use \common\components\helpers\BlockHelper;
use \common\components\helpers\AppHelper;

/* @var \yii\web\View $this */
/* @var $model common\models\Content */
/* @var $custom_tag_id int */
/* @var $department \common\models\Department */

echo \frontend\components\widgets\ContentWidget::widget(['model' => $model, 'department' => $department, 'isPage' => false, 'custom_tag_id' => $custom_tag_id,]);