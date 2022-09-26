<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Catalog;
use frontend\models\search\CatalogTreeSearch;
use yii\base\Widget;

class CatalogTabsWidget extends Widget
{
    const TAB_TREE = 'tree';
    const TAB_LIST = 'list';
    const TAB_DRAWING = 'drawing';

    public $activeTab;

    public function init()
    {
        parent::init();

        if (is_null($this->activeTab)) {
            $this->activeTab = self::TAB_TREE;
        }
    }

    public function run()
    {
        return $this->render('catalog_tabs', [
            'activeTab' => $this->activeTab,
        ]);
    }
}
