<?php
namespace frontend\widgets;

use common\models\Menu;
use yii\bootstrap4\Html;
use yii\helpers\VarDumper;

class LrNav extends \yii\base\Widget
{
    public $items = [];
    public $options = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $menu = Menu::find()->where(['front_visible' => true])->orderBy(['created_at'])->roots()->all();
        /*$nav = Html::tag('nav');
        foreach ($this->options as $option) {

        }*/
    }
}