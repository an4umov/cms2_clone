<?php

namespace cabinet\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main cabinet application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();

        $this->depends = [
//            'cabinet\assets\DashLiteAsset',
            'yii\web\YiiAsset',
//            'yii\bootstrap\BootstrapAsset',
        ];
    }
}
