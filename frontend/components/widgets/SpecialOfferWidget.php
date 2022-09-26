<?php

namespace frontend\components\widgets;

use common\components\helpers\ContentHelper;
use yii\base\Widget;

class SpecialOfferWidget extends Widget
{
    const LIMIT = 10;

    public $contentID = null;
    public $bid = null;
    public $header = '';
    public $headerColor = '';
    public $flag = '';
    public $groups = [];
    public $isRandom = false;
    public $isShowAllButton = false;
    public $isSlider = false;

    public function run()
    {
        return $this->render('special_offer', [
            'models' => ContentHelper::getSpecialOfferData($this->flag, $this->groups, $this->isRandom, self::LIMIT),
            'header' => $this->header,
            'headerColor' => $this->headerColor,
            'isShowAllButton' => $this->isShowAllButton,
            'isSlider' => $this->isSlider,
            'bid' => $this->bid,
            'contentID' => $this->contentID,
        ]);
    }
}
