<?php

use \common\components\helpers\ContentHelper;

/* @var \yii\web\View $this */
/* @var $model common\models\Content */
/* @var $custom_tag_id int */

echo ContentHelper::renderContent($model, false, null, $custom_tag_id);