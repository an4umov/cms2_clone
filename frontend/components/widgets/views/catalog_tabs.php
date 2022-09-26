<?php
/**
 * @var string $activeTab
 */

use \frontend\components\widgets\CatalogTabsWidget;
?>

<div class="container mycontainer catalog2_header">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <a <?= ($activeTab === CatalogTabsWidget::TAB_TREE ? 'class="active"' : '') ?> href="/catalog2">
                <div class="icon0"><i class="fas fa-boxes"></i></div>
                <div class="title0"><span>плитка</span></div>
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <a <?= ($activeTab === CatalogTabsWidget::TAB_LIST ? 'class="active"' : '') ?> href="/catalog2/list">
                <div class="icon0"><i class="fas fa-stream"></i></div>
                <div class="title0"><span>список</span></div>
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <a <?= ($activeTab === CatalogTabsWidget::TAB_DRAWING ? 'class="active"' : '') ?> href="/catalog2/drawing">
                <div class="icon0"><i class="fas fa-drafting-compass"></i></div>
                <div class="title0"><span>чертеж</span></div>
            </a>
        </div>
    </div>
</div>
