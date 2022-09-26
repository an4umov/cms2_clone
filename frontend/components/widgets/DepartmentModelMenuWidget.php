<?php

namespace frontend\components\widgets;

use common\models\Content;
use common\models\ContentFilter;
use common\models\Department;
use common\models\DepartmentMenuTagList;
use common\models\DepartmentModel;
use common\models\DepartmentModelList;
use yii\base\Widget;

class DepartmentModelMenuWidget extends Widget
{
    const ACTIVE_MODEL_ALL = 0;

    /** @var DepartmentModel */
    public $model;
    /** @var int */
    public $active_model_id;
    /** @var int */
    public $active_tag_id;

    public function init()
    {
        parent::init();

        if (is_null($this->active_model_id)) {
            $this->active_model_id = self::ACTIVE_MODEL_ALL;
        }
        if (is_null($this->active_tag_id)) {
            $this->active_tag_id = 0;
        }
    }

    public function run()
    {
        if (empty($this->active_tag_id)) {
            $modelList = $this->model->getDepartmentModelLists()->indexBy('id')->all();
        } else {
            $modelList = DepartmentModelList::find()
                ->innerJoin(ContentFilter::tableName(), DepartmentModelList::tableName().'.id = '.ContentFilter::tableName().'.list_id AND '.ContentFilter::tableName().'.type = :type1', [':type1' => ContentFilter::TYPE_MODEL,])
                ->innerJoin(ContentFilter::tableName().' AS cft', ContentFilter::tableName().'.content_id = cft.content_id AND cft.type = :type2', [':type2' => ContentFilter::TYPE_TAG,])
                ->where([
                    DepartmentModelList::tableName().'.is_active' => true,
                    DepartmentModelList::tableName().'.department_model_id' => $this->model->id,
                    'cft.list_id' => $this->active_tag_id,
                ])
                ->groupBy(DepartmentModelList::tableName().'.id')
                ->orderBy([DepartmentModelList::tableName() . '.sort' => SORT_ASC,])
                ->indexBy('id')
                ->all();
        }

        $allDepartmentModelList = new DepartmentModelList();
        $allDepartmentModelList->id = self::ACTIVE_MODEL_ALL;
        $allDepartmentModelList->name = DepartmentModel::DEFAULT_TITLE;
        $allDepartmentModelList->url = '/';
        $allDepartmentModelList->icon = '';

        $rows = [self::ACTIVE_MODEL_ALL => $allDepartmentModelList,] + $modelList;

        if (isset($rows[$this->active_model_id])) {
            $activeDepartmentModelList = $rows[$this->active_model_id];
            unset($rows[$this->active_model_id]);
        } else {
            $activeDepartmentModelList = $allDepartmentModelList;
            unset($rows[self::ACTIVE_MODEL_ALL]);
        }

        return $this->render('department_model_menu', [
            'rows' => $rows,
            'activeDepartmentModelList' => $activeDepartmentModelList,
        ]);
    }
}
