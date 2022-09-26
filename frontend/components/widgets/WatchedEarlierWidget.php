<?php

namespace frontend\components\widgets;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\models\Catalog;use common\models\Department;
use yii\base\Widget;
use yii\helpers\Json;

class WatchedEarlierWidget extends Widget
{
    public $group;
    public $groupTitle;
    public $trees;

    public function run()
    {
        $departments = $shops = [];
        $cookieValue = AppHelper::getCookieValue(CatalogHelper::COOKIE_MODELS_DEPARTMENTS_VIEW);

        if (!empty($cookieValue)) {
            $shops = Json::decode($cookieValue);

            if ($shops) {
                $departments = Department::find()->where(['url' => $shops, 'is_active' => true,])->asArray()->all();

                if ($this->groupTitle && $departments) {
                    foreach ($this->trees as $typeCode => $tree) {
                        if (!empty($tree[Catalog::TREE_LEVEL_THIRD])) {
                            foreach ($tree[Catalog::TREE_LEVEL_THIRD] as $modelCode => $generationData) {
                                foreach ($generationData[Catalog::TREE_ITEM_CHILDREN] as $generationCode => $generation) {
                                    //Простановка счетчика просмотренным департаментам
                                    foreach ($departments as $i => $department) {
                                        if (!empty($department['catalog_code']) && $department['catalog_code'] === $generationCode) {
                                            $departments[$i][Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] = $generation[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] ?? 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $this->render('watched_earlier', [
            'departments' => $departments,
            'groupTitle' => $this->groupTitle,
            'group' => $this->group,
            'trees' => $this->trees,
        ]);
    }
}