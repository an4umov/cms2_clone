<?php

namespace backend\modules\blocks\controllers;

use common\models\Block;
use Yii;

/**
 * Default controller for the `blocks` module
 */
class SettingController extends BlockController
{
    const TYPE = Block::TYPE_SETTING;

    public function init()
    {
        parent::init();

        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'block';
    }
}
