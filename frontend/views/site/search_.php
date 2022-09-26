<?php

use common\components\helpers\CartHelper;
use yii\widgets\ListView;

/* @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \frontend\models\search\SiteSearch $searchModel
 * @var string $shop
*/

$widgetID = 'search-list';
$this->title = 'Результаты поиска';
$this->params['searchModel'] = $searchModel;
if ($shop) {
    $this->params['shop'] = $shop;
}

if ($dataProvider->getTotalCount() > 0):
?>
<div style="margin-top: 5px" class="bottom_product1">
<?= ListView::widget([
    'id' => $widgetID,
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/catalog/_catalog_article',
    'layout' => "<div style=\"padding-top: 40px\" class=\"special_carousel\"><div class=\"container mycontainer special\">{items}</div></div>\n <div class=\"container mycontainer\"><div class=\"row\"><div class=\"col-12 ol-sm-12 col-md-12 col-lg-12 col-xl-12\"><div class=\"navigation0\">{pager}</div></div></div></div>",
    'itemOptions' => ['tag' => null,],
    'options' => ['tag' => null,],
    'emptyText' => false,
    'pager' => [
        'linkOptions' => ['class' => '',],
        'options' => ['class' => '',],
        'activePageCssClass' => 'active',
        'hideOnSinglePage' => false,
        'disabledPageCssClass' => 'disabled',
        'linkContainerOptions' => ['class' => '',],
        'maxButtonCount' => 6,
        'nextPageLabel' => 'следующая <i class="fas fa-angle-double-right"></i>',
        'prevPageLabel' => '<i class="fas fa-angle-double-left"></i> предыдущая',
        'prevPageCssClass' => 'nav_left',
        'nextPageCssClass' => 'nav_right',
    ],
]); ?>
</div>
<? else: ?>
<div class="blockk4" style="margin-top: 30px;">
    <div class="container mycontainer">
        <div class="row justify-content-center align-items-center">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="mr-2"><i class="fas fa-search"></i></div>
                <div>Ничего не найдено.</div>
            </div>
        </div>
    </div>
</div>
<? endif;?>