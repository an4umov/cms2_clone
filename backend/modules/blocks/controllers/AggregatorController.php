<?php

namespace backend\modules\blocks\controllers;


use backend\components\helpers\MenuHelper;
use common\models\Block;
use Yii;

/**
 * Default controller for the `blocks` module
 */
class AggregatorController extends BlockController
{
    const TYPE = Block::TYPE_AGGREGATOR;

    public function init()
    {
        parent::init();

        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'block';
        $this->getView()->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_AGGREGATOR;
    }
}
