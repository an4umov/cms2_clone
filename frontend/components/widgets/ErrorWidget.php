<?php
namespace frontend\components\widgets;
use yii\base\Widget;

class ErrorWidget extends Widget
{
    public $text;

    public function init()
    {
        parent::init();

        $this->text;
    }

    public function run()
    {
        return $this->render('error', [
            'text' => $this->text,
        ]);
    }
}
?>