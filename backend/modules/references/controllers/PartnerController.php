<?php

namespace backend\modules\references\controllers;

use backend\components\helpers\MenuHelper;
use common\models\ReferencePartner;
use Yii;


class PartnerController extends ReferencesController
{
    public function init()
    {
        parent::init();

        $this->setClass(ReferencePartner::class);
        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.MenuHelper::FIRST_MENU_REFERENCES.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.MenuHelper::FIRST_MENU_REFERENCES;
        $this->getView()->params['firstMenu'] = MenuHelper::FIRST_MENU_REFERENCES;
        $this->getView()->params['secondMenu'] = MenuHelper::SECOND_MENU_REFERENCES_PARTNER;
    }
}
