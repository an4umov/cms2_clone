<?php

namespace frontend\models\search;

use common\models\Articles;
use common\models\Catalog;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CatalogTreeSearch extends Catalog
{
    public function init()
    {
        parent::init();

        $this->level = self::LEVEL_1;
        $this->is_product = self::IS_PRODUCT_NO;
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params) : ActiveDataProvider
    {
        if (!empty($params['code'])) {
            $this->parent_code = $params['code'];
        }
        if (!empty($params['level'])) {
            $this->level = $params['level'];
        }

        $query = Catalog::find()
            ->orderBy(Catalog::tableName() . '.order ASC');
        $query->where([Catalog::tableName().'.parent_code' => $this->parent_code, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO,]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $dataProvider;
    }

    /**
     * @param Catalog $model
     *
     * @return array
     */
    public function findTopLevelModel(Catalog $model) : array
    {
        $result = ['model' => null, 'codes' => [$model->code => $model->code,],];
        $findCode = $model->parent_code;
        $icount = 1;

        if ($model->level == Catalog::LEVEL_3) {
            $result['model'] = $model;

            return $result;
        }

        while (true) {
            $result['codes'][$findCode] = $findCode;

            $parentModel = Catalog::find()->where([Catalog::tableName().'.code' => $findCode, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO,])->one();

            if (!empty($parentModel)) {
                if ($parentModel->level == Catalog::LEVEL_3) {
                    $result['model'] = $parentModel;

                    break;
                } else {
                    $findCode = $parentModel->parent_code;
                }
            } else {
                break;
            }

            $icount++;

            if ($icount >= 7) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param Catalog $model
     *
     * @return array
     */
    public function searchTreeFromTopLevel(Catalog $model) : array
    {
        $tree = [];

        /********* FIRST ***********/
        $query = Catalog::find()->orderBy([Catalog::tableName() . '.order' => SORT_ASC, Catalog::tableName() . '.name' => SORT_ASC,])->select(['id', 'level', 'parent_code', 'code', 'copy_of', 'name', 'full_name', 'description', 'title', 'link_anchor', 'link_tag', 'tag_for_link',]);
        $query->where([Catalog::tableName().'.parent_code' => $model->code, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO, /*Catalog::tableName().'.level' => self::LEVEL_4,*/]);
        $query->asArray()->indexBy('code');
        $firstRows = $query->all();
        $firstCodes = array_keys($firstRows);

        $tree[self::TREE_LEVEL_FIRST][self::TREE_ITEM_PARENT] = $model->attributes;
        $tree[self::TREE_LEVEL_FIRST][self::TREE_ITEM_CHILDREN] = $firstRows;

        foreach ($firstRows as $firstRowCode => $firstRow) {
            if (!empty($firstRow['copy_of'])) {
                $firstCodes[] = $firstRow['copy_of'];
            }
        }

        /********* SECOND ***********/
        $secondCodes = $secondRows = [];
        if ($firstCodes) {
            $query = Catalog::find()->orderBy([Catalog::tableName() . '.order' => SORT_ASC, Catalog::tableName() . '.name' => SORT_ASC,])->select(['id', 'level', 'parent_code', 'code', 'copy_of', 'name', 'full_name', 'description', 'title', 'link_anchor', 'link_tag', 'tag_for_link',]);
            $query->where([Catalog::tableName().'.parent_code' => $firstCodes, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO, /*Catalog::tableName().'.level' => self::LEVEL_5,*/]);
            $query->asArray()->indexBy('code');
            $secondRows = $query->all();
            $secondCodes = array_keys($secondRows);

            foreach ($firstRows as $firstRowCode => $firstRow) {
                $item = [
                    self::TREE_ITEM_PARENT => $firstRow,
                    self::TREE_ITEM_CHILDREN => [],
                ];

                foreach ($secondRows as $secondRowCode => $secondRow) {
                    if ($secondRow['parent_code'] === $firstRowCode) {
                        $item[self::TREE_ITEM_CHILDREN][$secondRowCode] = $secondRow;
                    }

                    if (!empty($firstRow['copy_of']) && $secondRow['parent_code'] === $firstRow['copy_of']) {
                        $item[self::TREE_ITEM_CHILDREN][$secondRowCode] = $secondRow;
                    }

                    if (!empty($secondRow['copy_of'])) {
                        $secondCodes[] = $secondRow['copy_of'];
                    }
                }

                $tree[self::TREE_LEVEL_SECOND][$firstRowCode] = $item;
            }
        }

        /********* THIRD ***********/
        $thirdRows = $thirdCodes = [];
        if ($secondCodes) {
            $query = Catalog::find()->orderBy([Catalog::tableName() . '.order' => SORT_ASC, Catalog::tableName() . '.name' => SORT_ASC,])->select(['id', 'level', 'parent_code', 'code', 'copy_of', 'name', 'full_name', 'description', 'title', 'link_anchor', 'link_tag', 'tag_for_link',]);
            $query->where([Catalog::tableName().'.parent_code' => $secondCodes, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO, /*Catalog::tableName().'.level' => self::LEVEL_6,*/]);
            $query->asArray()->indexBy('code');
            $thirdRows = $query->all();
            $thirdCodes = array_keys($thirdRows);

            foreach ($secondRows as $secondRowCode => $secondRow) {
                $item = [
                    self::TREE_ITEM_PARENT => $secondRow,
                    self::TREE_ITEM_CHILDREN => [],
                ];

                foreach ($thirdRows as $thirdRowCode => $thirdRow) {
                    if ($thirdRow['parent_code'] === $secondRowCode) {
                        $item[self::TREE_ITEM_CHILDREN][$thirdRowCode] = $thirdRow;
                    }

                    if (!empty($secondRow['copy_of']) && $thirdRow['parent_code'] === $secondRow['copy_of']) {
                        $item[self::TREE_ITEM_CHILDREN][$thirdRowCode] = $thirdRow;
                    }

                    if (!empty($thirdRow['copy_of'])) {
                        $thirdCodes[] = $thirdRow['copy_of'];
                    }
                }

                $tree[self::TREE_LEVEL_THIRD][$secondRowCode] = $item;
            }
        }

        /********* FOURTH ***********/
        if ($thirdCodes) {
            $query = Catalog::find()->orderBy([Catalog::tableName() . '.order' => SORT_ASC, Catalog::tableName() . '.name' => SORT_ASC,])->select(['id', 'level', 'parent_code', 'code', 'name', 'full_name', 'description', 'title', 'link_anchor', 'link_tag', 'tag_for_link',]);
            $query->where([Catalog::tableName().'.parent_code' => $thirdCodes, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO, /*Catalog::tableName().'.level' => self::LEVEL_7,*/]);
            $query->asArray()->indexBy('code');
            $fourthRows = $query->all();
//            $fourthCodes = array_keys($fourthRows);

            foreach ($thirdRows as $thirdRowCode => $thirdRow) {
                $item = [
                    self::TREE_ITEM_PARENT => $thirdRow,
                    self::TREE_ITEM_CHILDREN => [],
                ];

                foreach ($fourthRows as $fourthRowCode => $fourthRow) {
                    if ($fourthRow['parent_code'] === $thirdRowCode) {
                        $item[self::TREE_ITEM_CHILDREN][$fourthRowCode] = $fourthRow;
                    }
                }

                $tree[self::TREE_LEVEL_FOURTH][$thirdRowCode] = $item;
            }
        }

        /********* FIFTH ***********/
//        $query = Catalog::find()->orderBy(Catalog::tableName() . '.order ASC')->select(['level', 'parent_code', 'code', 'name', 'full_name', 'description', 'title',]);
//        $query->where([Catalog::tableName().'.parent_code' => $fourthCodes, Catalog::tableName() . '.is_product' => self::IS_PRODUCT_NO,]);
//        $query->asArray()->indexBy('code');
//        $fifthRows = $query->all();
//
//        foreach ($fourthRows as $fourthRowCode => $fourthRow) {
//            $item = [
//                self::TREE_ITEM_PARENT => $fourthRow,
//                self::TREE_ITEM_CHILDREN => [],
//            ];
//
//            foreach ($fifthRows as $fifthRowCode => $fifthRow) {
//                if ($fifthRow['parent_code'] === $fourthRowCode) {
//                    $item[self::TREE_ITEM_CHILDREN][$fifthRowCode] = $fifthRow;
//                }
//            }
//
//            $tree[self::TREE_LEVEL_FIFTH][$fourthRowCode] = $item;
//        }

        return $tree;
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchArticles(array $params) : ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider();

        if (!empty($params['code'])) {
            $query = Articles::find()->select(Articles::tableName().'.*')
                ->innerJoin(Catalog::tableName(), Articles::tableName().'.number = '.Catalog::tableName().'.article')
                ->where([
                    Catalog::tableName() . '.parent_code' => $params['code'],
                    Catalog::tableName() . '.is_product' => self::IS_PRODUCT_YES,
                ])
                ->orderBy(Catalog::tableName() . '.order ASC');

            $dataProvider->query = $query;
            $dataProvider->pagination = ['pageSize' => 10,];
        }

        return $dataProvider;
    }
}
