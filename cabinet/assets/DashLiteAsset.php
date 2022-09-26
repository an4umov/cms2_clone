<?php

namespace cabinet\assets;

use yii\web\AssetBundle;

/**
 * Dashlite asset bundle.
 */
class DashLiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();

        $version = time().'-'.rand(1, 100);

        $this->css = [
            'css/dashlite.css?v='.$version,
            'css/theme.css?v='.$version,
            'css/custom.css?v='.$version,
        ];

        $this->js = [
            'js/bundle.js?v='.$version,
            'js/scripts.js?v='.$version,
            'js/custom.js?v='.$version,
        ];

        $this->jsOptions = [
            'position' => \yii\web\View::POS_HEAD,
        ];

        $this->depends = [];
    }
}
