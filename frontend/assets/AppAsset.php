<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
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
            'css/style.css?v='.time(),
        ];
        $this->js = [
            'js/third-party/jquery.min.js?'.$version,
            'js/third-party/jquery.suggestions.min.js?'.$version,
            'js/script.js?'.$version,
        ];
        $this->depends = [
//            'yii\web\YiiAsset',
//            'yii\bootstrap4\BootstrapAsset',
        ];
/*
        $catalogList = [
            'app-frontend/catalog/index' => true,
            'app-frontend/catalog2/index' => true,
            'app-frontend/catalog2/list' => true,
            'app-frontend/catalog/category' => true,
        ];
        if (isset($catalogList[$key])) {
//            $this->js[] = 'js/catalog.js?v='.$version;
        }

        if ($key === 'app-frontend/shop/code') {
//            $this->js[] = 'js/jquery.flexslider.js?v='.$version;
//            $this->js[] = 'js/article.js?v='.$version;
//            $this->css[] = 'css/flexslider.css?v='.$version;
        } */
    }
}
