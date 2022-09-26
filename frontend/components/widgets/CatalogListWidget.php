<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Catalog;
use frontend\models\search\CatalogListSearch;
use yii\base\Widget;

class CatalogListWidget extends Widget
{
    const CODE_LAND_ROVER = 'KAT0000003';
    const CACHE_KEY = 'catalog-list-data';
    const CACHE_CATALOG_GROUP_DEPARTMENT = 'catalog-group-department';
    const CACHE_CATALOG_STRUCTURE_DATA = 'catalog-structure-data';
    const CACHE_CATALOG_STRUCTURE_DATA_DURATION = 3600 * 24 * 7;
    const CACHE_TREE_KEY = 'catalog-tree-data';
    const CACHE_DURATION = 3600 * 24;

    public $code;
    /**
     * @var Catalog
     */
    public $model;

    /** @var string */
    public $id = 'catalog-list';

    public function init()
    {
        parent::init();

        if (is_null($this->code)) {
            $this->code = self::CODE_LAND_ROVER;
        }

        if (!empty($this->code)) {
            $this->model = CatalogHelper::getCatalogModelByCode($this->code);
        }
    }

    public function run()
    {
        return $this->render('catalog_list', [
            'id' => $this->id,
            'data' => CatalogHelper::getCatalogListData($this->code),
            'model' => $this->model,
        ]);
    }
}
