<?php


namespace backend\controllers;


use backend\models\forms\ContentItemForm;
use common\models\Menu;
use common\models\Material;
use common\models\Tag;
use core\DynamicMenu;
use frontend\widgets\LrNav;
use yii\base\Module;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;

class ZetController extends Controller
{
    private $menu;

    public function __construct(string $id, Module $module, DynamicMenu $menu, array $config = [])
    {
        $this->menu = $menu;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
    }
}