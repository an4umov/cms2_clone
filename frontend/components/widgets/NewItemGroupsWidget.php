<?php

namespace frontend\components\widgets;

use common\components\helpers\ContentHelper;
use common\models\Block;
use common\models\BlockField;
use common\models\Catalog;
use common\models\Content;
use common\models\Department;
use yii\base\Widget;
use yii\helpers\Json;

class NewItemGroupsWidget extends Widget
{
    /** @var Content */
    public $model;

    public function run()
    {
        $used = [];
        $itemGroups = Catalog::find()->where(['parent_code' => Catalog::ITEM_GROUPS_CODE, 'is_department' => true,])->asArray()->orderBy(['order' => SORT_ASC,])->all();

        if ($itemGroups) {
            $blockFieldIDs = BlockField::find()->where(['type' => BlockField::TYPE_DEPARTMENTS,])->select('id')->indexBy('id')->column();
            $departments = Department::find()->where(['is_active' => true,])->asArray()->indexBy('id')->all();

            $rows = ContentHelper::getUsedDepartments($this->model);
            foreach ($rows as $row) {
                if (in_array($row['global_type'], [Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1, Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2, Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3, Block::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6,])) {
                    $data = Json::decode($row['data']);
                    foreach ($data as $id => $value) {
                        $value = intval($value);
                        if (isset($blockFieldIDs[$id]) && isset($departments[$value])) {
                            $used[$value] = $departments[$value];
                        }
                    }
                }
            }

            foreach ($itemGroups as $i => $itemGroup) {
                foreach ($used as $id => $department) {
                    if ($itemGroup['code'] === $department['catalog_code']) {
                        unset($itemGroups[$i]);
                    }
                }
            }
        }

        return $this->render('new_item_groups', [
            'rows' => $itemGroups,
        ]);
    }
}
