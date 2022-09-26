<?php
/**
 * @var string $id
 * @var array $data
 * @var Catalog $model
 */

use \common\components\helpers\CatalogHelper;
use \common\models\Catalog;
use \yii\widgets\ListView;

//echo \yii\helpers\Html::style('.empty { padding: 15px; } i.fas.fa-times.cl { margin-top: 2px; margin-left: 3px;}');
?>

<div class="container mycontainer">
<? CatalogHelper::printCatalogListHtml($data, /*$model->code*/0) ?>
</div>
