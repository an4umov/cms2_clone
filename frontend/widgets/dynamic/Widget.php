<?php


namespace frontend\widgets\dynamic;


use common\models\Tile;
use services\CommonWidgetsService;
use \yii\base\Widget as WidgetClass;
use \common\models\Widget as WidgetModel;
use yii\helpers\VarDumper;

class Widget extends WidgetClass
{
    public $id;
    public $type;
    /** @var WidgetModel */
    private $widgetItem;
    private $service;

    public function __construct(CommonWidgetsService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
    }

    public function init()
    {
        $this->widgetItem = WidgetModel::find()->where(['id' => $this->id])->one();
    }

    public function run()
    {
        if (!is_null($this->widgetItem)) {
            return $this->render('widget/'.WidgetModel::$shortcodes[$this->widgetItem->type] . '-' . $this->widgetItem->type, [
                'item' => $this->widgetItem
            ]);
        }
        return null;
    }
}