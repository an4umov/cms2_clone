<?php

namespace frontend\widgets\dynamic;


use common\models\SliderTile;
use common\models\Tile;
use services\CommonWidgetsService;
use yii\base\Widget;

class SliderTileWidget extends Widget
{
    public $id;
    public $type;
    private $slider;
    private $service;

    public function __construct(CommonWidgetsService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
    }

    public function init()
    {
        $this->slider = SliderTile::find()->where(['id' => $this->id])->one();
    }

    public function run()
    {
        if (!is_null($this->slider)) {
            return $this->render('slider-tile', [
                'slider' => $this->slider
            ]);
        }
        return null;
    }
}