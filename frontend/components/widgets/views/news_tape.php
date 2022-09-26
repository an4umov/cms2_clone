<?php
/**
 * @var $this yii\web\View
 * @var \common\models\Content[] $models
 * @var string $header
 */

use \common\components\helpers\ContentHelper;
use yii\helpers\Url;
?>
<?= $header ?>
<? foreach ($models as $model): ?>
<?= ContentHelper::renderContent($model, false, null, 0); ?>
<? endforeach; ?>
<?
    // пока не готово, но должно быть тут
    //ContentHelper::renderModalAsk($model->id, $model->type).PHP_EOL;
    //ContentHelper::renderModalShare($model->id, $model->type, $model->getContentUrl($department)).PHP_EOL;
?>
