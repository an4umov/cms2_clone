<?php

namespace frontend\widgets\dynamic;


use common\models\Tile;
use services\CommonWidgetsService;
use yii\base\Widget;

class TileWidget extends Widget
{
    public $id;
    public $type;
    private $tile;
    private $service;

    public function __construct(CommonWidgetsService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
    }

    public function init()
    {
        $this->tile = Tile::find()->where(['id' => $this->id])->one();
    }

    public function run()
    {
        if (!is_null($this->tile)) {
            return $this->render('tile', [
                'tile' => $this->tile
            ]);
        }
        return null;
    }
}