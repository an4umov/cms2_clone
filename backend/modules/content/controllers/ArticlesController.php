<?php

namespace backend\modules\content\controllers;

use backend\components\helpers\MenuHelper;
use common\models\Content;
use Yii;


class ArticlesController extends ContentController
{
    const TYPE = Content::TYPE_ARTICLE;

    public function init()
    {
        parent::init();

        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'content';
        $this->getView()->params['firstMenu'] = MenuHelper::FIRST_MENU_CONTENT;
        $this->getView()->params['secondMenu'] = MenuHelper::SECOND_MENU_CONTENT_ARTICLES;

    }
}
