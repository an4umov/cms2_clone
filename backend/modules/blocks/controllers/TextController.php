<?php

namespace backend\modules\blocks\controllers;

use common\models\Block;
use Yii;

/**
 * Default controller for the `blocks` module
 */
class TextController extends BlockController
{
    const TYPE = Block::TYPE_TEXT;

    public function init()
    {
        parent::init();

        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'block';
    }
}
