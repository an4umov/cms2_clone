<?php

use \common\models\Catalog;

/* @var \common\models\Catalog $model
/* @var \common\models\CatalogTreeSetting $setting
 * @var \yii\web\View $this
 * @var int $index
 */
$index += 1;

if ($model->is_product === Catalog::IS_PRODUCT_NO) {
    $view = '_catalog_item';
} else {
    $view = '_catalog_article';
}

echo $this->render($view, [
    'model' => $model,
    'setting' => $setting,
]);