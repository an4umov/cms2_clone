<?php

namespace frontend\assets;


use yii\web\AssetBundle;

class LrAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();

        $version = time(); // Yii::$app->version;
        $controller = \Yii::$app->controller;
        $key = "{$controller->module->id}/{$controller->id}/{$controller->action->id}";

        //        echo $key;

        $this->css = [
            'https://final.lr.ru/css/style_lrparts.min.css?v='.$version,
        ];
        $this->js = [
            'https://final.lr.ru/js/script_lrparts.js?v='.$version,
        ];
        $this->depends = [];
    }
}