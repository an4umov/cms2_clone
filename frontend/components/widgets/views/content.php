<?php
/* @var \yii\web\View $this */
/* @var $model common\models\Content */
/* @var $department \common\models\Department */
/* @var $isPage bool */
/* @var $custom_tag_id integer */

echo \common\components\helpers\ContentHelper::renderContent($model, $isPage, $department, $custom_tag_id);