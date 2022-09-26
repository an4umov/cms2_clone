<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Catalog;
use frontend\models\search\CatalogTreeSearch;
use yii\base\Widget;

class CatalogTreeWidget extends Widget
{
    const CODE_LAND_ROVER = 'KAT0000003';

    /** @var string */
    public $code;

    /** @var string */
    public $selectedCode;

    /** @var string */
    public $content;

    /**
     * @var Catalog
     */
    public $model;

    /** @var string */
    public $id = 'catalog-tree';

    public function init()
    {
        parent::init();

        if (is_null($this->code)) {
            $this->code = self::CODE_LAND_ROVER;
        }

        if (is_null($this->content)) {
            $this->content = '';
        }

        if (!empty($this->code)) {
            $this->model = CatalogHelper::getCatalogModelByCode($this->code);
        }
    }

    public function run()
    {
        return $this->render('catalog_tree', [
            'id' => $this->id,
            'dataProvider' => (new CatalogTreeSearch())->search(['code' => $this->code,]),
            'model' => $this->model,
            'selectedCode' => $this->selectedCode,
            'content' => $this->content,
        ]);
    }
}
