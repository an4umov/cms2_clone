<?php

namespace frontend\components\widgets;

use common\components\helpers\DepartmentHelper;
use common\models\ContentFilterPage;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use yii\base\Widget;

class HeaderGreenMenuWidget extends Widget
{
    public $shop;
    public $activeMenu;
    public $activeTag;

    public function init()
    {
        parent::init();

        if (is_null($this->shop)) {
            $this->shop = DepartmentMenuWidget::ACTIVE_SHOP_ALL;
        }
    }

    public function run()
    {
        $departmentMenus = $departmentMenuTags = [];

        if ($this->shop === DepartmentMenuWidget::ACTIVE_SHOP_ALL) {
            $department = Department::findOne(['is_default' => true,]);
        } else {
            $department = DepartmentHelper::getDepartmentByUrl($this->shop);
        }

        if ($department) {
            $query = DepartmentMenu::find();
            $query->where(['department_id' => $department->id, 'is_active' => true,]);
            $query->orderBy(['sort' => SORT_ASC,]);
            $query->asArray();
            $query->indexBy('url');

            $departmentMenus = $query->all();

            if (!empty($this->activeMenu) && isset($departmentMenus[$this->activeMenu])) {
                $departmentMenu = $departmentMenus[$this->activeMenu];

                $query = DepartmentMenuTag::find();
                $query->select(['id', 'name', 'url', 'image',]);
                $query->where(['department_menu_id' => $departmentMenu['id'], 'is_active' => true,]);
                $query->orderBy(['sort' => SORT_ASC,]);
                $query->asArray(true);

                $departmentMenuTags = $query->all();
            }

            $this->shop = $department->url;
        }

        return $this->render('header_green_menu', [
            'shop' => $this->shop,
            'activeMenu' => $this->activeMenu,
            'activeTag' => $this->activeTag,
            'departmentMenus' => $departmentMenus,
            'departmentMenuTags' => $departmentMenuTags,
            'allContentFilterPages' => ContentFilterPage::find()->select(['content_id', 'type', 'department_content_id',])->where(['type' => ContentFilterPage::TYPE_DEPARTMENT_MENU,])->asArray()->all(),
        ]);
    }
}
