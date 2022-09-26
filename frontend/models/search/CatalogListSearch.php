<?php

namespace frontend\models\search;

use common\models\Catalog;
use frontend\components\widgets\CatalogListWidget;
use yii\data\ActiveDataProvider;

class CatalogListSearch extends Catalog
{
    public function init()
    {
        parent::init();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search($params) : array
    {
        $where = [];
        if (!empty($params['code'])) {
            $this->parent_code = $params['code'];
        } else {
            $this->parent_code = CatalogListWidget::CODE_LAND_ROVER;
        }

        if (empty($params['with_products'])) {
            $where = [Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO,];
        }

        $query = Catalog::find()
            ->select([
                Catalog::tableName().'.name',
                Catalog::tableName().'.code',
                Catalog::tableName().'.parent_code',
                Catalog::tableName().'.description',
            ])
            ->orderBy(Catalog::tableName() . '.order ASC')
            ->indexBy('code')
            ->asArray();

        if ($where) {
            $query->where($where);
        }

        return $this->_makeTree($query->all(), CatalogListWidget::CODE_LAND_ROVER);
    }

    /**
     * @param      $data
     * @param null $parentCode
     *
     * @return array
     */
    private function _makeTree($data, $parentCode = null) {
        $tree = array();

        foreach ($data as $node) {
            if ($node['parent_code'] === $parentCode) {
                $node['children'] = $this->_makeTree($data, $node['code']);

                $tree[$node['code']] = $node;
            }
        }

        return $tree;
    }
}
