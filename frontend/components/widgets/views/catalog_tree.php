<?php
/**
 * @var string $id
 * @var string $selectedCode
 * @var string $content
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Catalog $model
 */

use \common\components\helpers\CatalogHelper;
use \common\models\Catalog;
use \yii\widgets\ListView;

echo \yii\helpers\Html::style('.empty { padding: 15px; } i.fas.fa-times.cl { margin-top: 2px; margin-left: 3px;}');
$setting = CatalogHelper::getCatalogTreeSetting();
?>

<div class="container mycontainer catalog0" id="catalog-tree-parent-container" data-code="<?= $model->code ?>" data-level="1">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h3 style="font-weight: <?= $setting->header_font_size ?>px;"><i class="fas fa-ellipsis-v"></i> <?= $model->full_name ?> <?= CatalogHelper::getCatalogLoader($model->level) ?></h3>
        </div>
        <?=  ListView::widget([
            'id' => $id,
            'dataProvider' => $dataProvider,
            'itemView' => '@frontend/views/catalog/_catalog_item',
            'layout' => '{items}',
            'itemOptions' => ['tag' => null,],
            'viewParams' => ['setting' => $setting, 'selectedCode' => $selectedCode,],
            'options' => ['tag' => null,],
        ]);
        ?>
    </div>
</div>
<div id="catalog-container"><?= $content ?></div>