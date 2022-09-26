<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-cabinet',
    'name' => 'LR-CMS',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'cabinet\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-cabinet',
        ],
        'user' => [
            'identityClass' => 'common\models\UserLk',
            'class' => 'cabinet\components\UserLk',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-cabinet', 'httpOnly' => true, 'domain' => '.'.$_SERVER['SERVER_NAME'],],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the cabinet
            'name' => 'advanced-cabinet',
            'timeout' => 86400 * 7,
            'cookieParams' => ['httpOnly' => true, 'domain' => '.'.$_SERVER['SERVER_NAME'],],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\bootstrap4\BootstrapAsset' => false,
                //                'yii\web\JqueryAsset' => [
                //                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                //                ],
                'yii\web\JqueryAsset' => false,
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '/catalog' => 'site/catalog',
                '/chat' => 'site/chat',
                '/favorite' => 'site/favorite',
                '/transport' => 'site/transport',
                '/bonuses' => 'site/bonuses',
                '/balance' => 'site/balance',
                '/files' => 'site/files',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@vendor/amnah/yii2-user/views' => '@app/views/user',
                ],
            ],
        ],
        'fileManager' => [
            'class' => 'rkit\filemanager\FileManager',
            // 'sessionName' => 'filemanager.uploads',
        ],
        // any flysystem component for storage, for example https://github.com/creocoder/yii2-flysystem
        'localFs' => [
            'class' => 'creocoder\flysystem\LocalFilesystem',
            'path' => '@uploads/images',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
            'modelClasses' => [
                'UserSearch' => \cabinet\models\UserSearch::class,
            ],
            'controllerMap' => [
                'admin' => null,
            ],
            'loginUsername' => false,
            'loginRedirect' => '/',
        ],
    ],
    'params' => $params,
    'language' => 'ru-RU',
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login', 'register', 'forgot', 'error', 'reset', 'confirm',],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
];
