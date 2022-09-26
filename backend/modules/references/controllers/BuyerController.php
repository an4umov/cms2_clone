<?php

namespace backend\modules\references\controllers;

use backend\components\helpers\MenuHelper;
use common\models\ReferenceBuyer;
use Yii;


class BuyerController extends ReferencesController
{
    public function init()
    {
        parent::init();

        $this->setClass(ReferenceBuyer::class);
        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.MenuHelper::FIRST_MENU_REFERENCES.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.MenuHelper::FIRST_MENU_REFERENCES;
        $this->getView()->params['firstMenu'] = MenuHelper::FIRST_MENU_REFERENCES;
        $this->getView()->params['secondMenu'] = MenuHelper::SECOND_MENU_REFERENCES_BUYER;
    }
}
