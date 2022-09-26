<?php

namespace frontend\components\widgets;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\components\helpers\DepartmentHelper;
use common\models\Content;
use common\models\ContentFilterPage;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use common\models\GreenMenu;
use yii\base\Widget;
use yii\web\NotFoundHttpException;

class HeaderGreenMenuNewWidget extends Widget
{
    public $activeMenu;

    public function run()
    {
        $departmentMenu = GreenMenu::findOne(['is_department_menu' => true, 'is_enabled' => true,]);
        $greenMenus = GreenMenu::find()->where(['is_department_menu' => false, 'is_enabled' => true,])->with('landingPage')->all();

        $lastModelsUrl = AppHelper::getCookieValue(CatalogHelper::COOKIE_MODELS_LAST_URL);
        $lastGroupsUrl = AppHelper::getCookieValue(CatalogHelper::COOKIE_GROUPS_LAST_URL);

        return $this->render('header_green_menu_new', [
            'activeMenu' => $this->activeMenu,
            'departmentMenu' => $departmentMenu,
            'greenMenus' => $greenMenus,
            'lastModelsUrl' => $lastModelsUrl,
            'lastGroupsUrl' => $lastGroupsUrl,
        ]);
    }
}
