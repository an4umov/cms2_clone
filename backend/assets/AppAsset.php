<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();

        $this->css = [
//            'css/font-awesome/css/font-awesome.min.css',
            'css/owl.carousel.css',
            'fancybox/source/jquery.fancybox.css',
            'css/bootstrap-reset.css?v='.time(),
            'css/style.css?v='.time(),
            'css/style-responsive.css',
            'css/table-responsive.css',
            'css/jquery.gritter.css',
            'css/tasks.css?v='.time(),
            'css/gallery.css?v='.time(),
            'css/dashforge.filemgr.css?v='.time(),
            'css/zTreeStyle/zTreeStyle.css',
            'css/jquery-ui.css',
//            '//www.fuelcdn.com/fuelux/3.13.0/css/fuelux.min.css',
//            '//www.fuelcdn.com/fuelux-mctheme/1.1.0/css/fuelux-mctheme.min.css',
//            'js/plugins/fuelux/css/tree_.css',
//            'js/plugins/fuelux/css/tree-style.css',
//            'css/site.css?v='.time(),
        ];

        $this->js = [
            'js/tools.js',
            'js/material.js',
            'js/plugins/jquery.validate.min.js',
            'js/plugins/jquery.gritter.min.js',
            'js/plugins/jquery.blockUI.js',
//            'js/plugins/fuelux/js/tree.min.js',
//            '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
            'js/plugins/jquery.ztree.core.min.js',
            'js/plugins/jquery.ztree.excheck.min.js',
            'js/plugins/jquery.ztree.exedit.min.js',
            'js/plugins/jquery-ui.min.js',
//            '//www.fuelcdn.com/fuelux/3.13.0/js/fuelux.min.js',
            'js/app.js?v='.time(),
//            'js/tree2.js?v='.time(),
//            'http://code.jquery.com/ui/1.10.3/jquery-ui.js',
            'fancybox/source/jquery.fancybox.js',
        ];

        $this->depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'yii\bootstrap\BootstrapPluginAsset',
        ];

        Yii::setAlias('@jscommon', '@web/common/js');
        Yii::setAlias('@jsapp', '@web/js');
        Yii::setAlias('@jsapproot', '@webroot/js');

        $version = time();
        $controller = Yii::$app->controller;

        /** @todo think about map */
        $map = [
//            'user/admin/index' => 'app/admin/user-index.js',
//            'user/admin/update' => 'app/admin/user-update.js',
//            'user/admin/requests' => 'app/admin/user-update.js',
//            'user/admin/update-profile' => 'app/admin/user-update.js',
//            'user/admin/notifications' => 'app/admin/user-update.js',
//            'user/admin/site-settings' => 'app/admin/user-update.js',
//            'user/admin/social-networks' => 'app/admin/user-update.js',
//            'user/admin/info' => 'app/admin/user-update.js',
//            'user/admin/assignments' => 'app/admin/user-update.js',
//            'app-backend/review/index' => 'app/review/index.js',
//            'app-backend/review/view' => 'app/review/index.js',
//            'app-backend/comment/view' => ['app/review-comment/index.js', 'app/article-comment/index.js',],
//            'app-backend/review-comment/view' => 'app/review-comment/index.js',

//            'app-backend/settings/migration' => 'js/plugins/jquery.dcjqaccordion.2.7.min.js',
        ];

        $key = "{$controller->module->id}/{$controller->id}/{$controller->action->id}";
//        echo $key;

        if (isset($map[$key])) {
            $js = $map[$key];
        } else if ($controller->module->id !== \Yii::$app->id) {
            $js = $controller->module->id . '/' . $controller->id . '/' . $controller->action->id . '.js';
        } else {
            $js = 'app/'. $controller->id . '/' . $controller->action->id . '.js';
        }

        if (!is_array($js)) {
            $js = [$js,];
        }

        if ($key === 'form/form/update' || $key === 'form/form/create') {
            $this->js[] = 'js/plugins/jquery.tagsinput.js';
        }

        foreach ($js as $j) {
            if (file_exists(Yii::getAlias("@jsapproot/{$j}"))) {
                $this->js[] = Yii::getAlias("@jsapp/{$j}?v={$version}");
            };
        }
    }
}
