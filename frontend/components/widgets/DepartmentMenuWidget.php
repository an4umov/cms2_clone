<?php

namespace frontend\components\widgets;

use common\components\helpers\AppHelper;
use common\models\Department;
use yii\base\Widget;

class DepartmentMenuWidget extends Widget
{
    const ACTIVE_SHOP_ALL = 'all';

    public $slogan;
    public $activeShop;

    public function init()
    {
        parent::init();

        if (is_null($this->activeShop)) {
            $this->activeShop = self::ACTIVE_SHOP_ALL;
        }
    }

    public function run()
    {
        $queryD = Department::find()
            ->where(['is_active' => true, 'is_default' => false,])
            ->indexBy('url')
            ->orderBy(['sort' => SORT_ASC,]);

        $allDepartment = Department::findOne(['is_default' => true,]);
        if (!$allDepartment) {
            $allDepartment = new Department();
            $allDepartment->name = 'Выберите раздел';
            $allDepartment->url = '/';
            $allDepartment->icon = '';
        }

        $rows = [self::ACTIVE_SHOP_ALL => $allDepartment,] + $queryD->all();

        if (isset($rows[$this->activeShop])) {
            $activeDepartment = $rows[$this->activeShop];
            unset($rows[$this->activeShop]);
        } else {
            $activeDepartment = $allDepartment;
            unset($rows[self::ACTIVE_SHOP_ALL]);
        }

//        $department = null;
//        if (!empty($this->activeShop) && $this->activeShop !== self::ACTIVE_SHOP_ALL) {
//            $department = Department::findOne(['url' => $this->activeShop, 'is_active' => true,]);
//        }

        $list = [];
        $activeCarModel = '';
        $carModelID = \Yii::$app->request->get(AppHelper::TEMPLATE_KEY_CAR_MODEL, null);

        if ($carModelID === 0) {
            AppHelper::deleteCookie(AppHelper::TEMPLATE_KEY_CAR_MODEL);
        } elseif (is_numeric($carModelID) && $carModelID > 0) {
            AppHelper::setCookieValue(AppHelper::TEMPLATE_KEY_CAR_MODEL, (int)$carModelID);
        } else {
            $carModelID = AppHelper::getCookieValue(AppHelper::TEMPLATE_KEY_CAR_MODEL);
        }

//        if ($department) {
//            $list = \common\components\helpers\DepartmentHelper::getCarModelOptions();
//
//            if (!empty($carModelID) && isset($list[$carModelID])) {
//                $activeCarModel = $list[$carModelID];
//            }
//        }

        return $this->render('department_menu', [
            'departments' => $rows,
            'modelList' => $list,
            'activeDepartment' => $activeDepartment,
            'activeCarModel' => $activeCarModel,
            'slogan' => $this->slogan,
            'carModelID' => $carModelID,
        ]);
    }
}
