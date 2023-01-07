<?php

use common\models\PriceList;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

if ($_SERVER['SERVER_NAME'] == 'epc.lr.ru') {
    $curHome = '/';
} else {
    $curHome = '/epc';
}
//echo $_SERVER['SERVER_NAME'];
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'aliases' => [
        '@guayaquil' => '@vendor/guayaquillib/com_guayaquil', //Class 'guayaquil\guayaquillib\data\GuayaquilRequestOEM' not found
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'sdfsd5fgAdfgdG3tdfgf2499sdGFs',
        ],
        'user' => [
            'identityClass' => 'common\models\UserLk',
            'class' => 'cabinet\components\UserLk',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-cabinet', 'httpOnly' => true, 'domain' => '.'.$_SERVER['SERVER_NAME'],],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
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
                '/catalog/offers/<code>' => 'catalog/offers', // товарные предложения через AJAX
                //'/catalog/offers/<code>' => 'catalog/offers', // товарные предложения через AJAX
                '/catalog/<code>' => 'catalog/view', //страница Каталога

                '/departments' => 'catalog/departments', //Группы товаров
                '/models' => 'catalog/models', //Модели авто

                '/dep/<shop:\H+>/<menu:\H+>/<tag:\H+>/<number>/<key>' => 'shop/product', //отдельная страница товара
                '/dep/<shop:\H+>/<menu:\H+>/<tag:\H+>/<number>' => 'shop/vendor', //страница Артикула

                '/product/<number>' => 'shop/vendor', //страница Артикула
                '/product/<number>/<key>' => 'shop/product', //отдельная страница товара

                // OLD SHIT

                // '/shop/code/<code>' => 'catalog/category', //старая какая то страница
                // '/product/<code>' => 'shop/product', //страница Товарного Предложения ?id=<key>
                // '/article/<number:\H+>' => 'article/view',
                // '/article/show/<number:\H+>' => 'article/show',
                // '/dep/<shop:\H+>/<menu:\H+>/<code:\H+>' => 'shop/code',

                '/dep/<shop:\H+>/news/<alias:[\w\.\-]+>' => 'shop/shop',
                '/dep/<shop:\H+>/<menu:\H+>/<tag:\H+>' => 'shop/shop', //тематика департамента
                '/dep/<shop:\H+>/<menu:\H+>' => 'shop/shop', //меню департамента

                '/dep/<shop:\H+>' => 'shop/shop', //департамент

                $curHome => 'lr-parts/index', //Каталог Land Rover
                $curHome.'<id:\d+>' => 'lr-parts/view',
                $curHome.'search/<text:\H+>' => 'lr-parts/search',
                $curHome.'search' => 'lr-parts/search',

                '<controller:(articles|news|pages)>' => 'content/<controller>-index',
                '<controller:(articles|news|pages)>/<alias:[\w\.\-]+>' => 'content/<controller>-alias',

                '/checkout/order-pay/<id:\d+>' => 'checkout/order-pay',
                '/checkout/order-received/<id:\d+>' => 'checkout/order-received',
                '/checkout/order-received-test/<id:\d+>' => 'checkout/order-received-test',
                '/checkout/order-canceled/<id:\d+>' => 'checkout/order-canceled',
                '/checkout/refund-succeeded/<id:\d+>' => 'checkout/refund-succeeded',

                '/form/render/<id:\d+>' => 'form/render',

                '/unyU8F1wUcHLEzdwwH8gD8duoiUt8Gi1' => 'console/webhook',

//                '/articles' => 'content/index',
//                '/articles/<id:\d+>' => 'content/view',
//                '/news' => 'content/index',
//                '/news/<id:\d+>' => 'content/view',
//                '/pages' => 'content/pages-index',
//                '/pages/<id:\d+>' => 'content/pages-view',

                'search' => 'site/search',
                'test' => 'test/index',
                '/special/<id:\d+>' => 'site/special',
                'data' => 'test/data',
                'form-send' => 'site/form-send',
                'question-send' => 'site/question-send',

                //['class' => \frontend\rules\AliasUrlRule::class],
            ],
        ],
        'cart' => [
            'class' => 'devanych\cart\Cart',
            'storageClass' => 'devanych\cart\storage\CookieStorage',
            'calculatorClass' => 'devanych\cart\calculators\SimpleCalculator',
            'params' => [
                'key' => 'cart',
                'expire' => 1209600,
                'productClass' => 'common\models\PriceList',
                'productFieldId' => PriceList::PRODUCT_KEY,
                'productFieldPrice' => 'price',
            ],
        ],
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file' => __DIR__.'/../../yii',
        ],
        'view' => [
            /*
            'as shortcodeBehavior' => alexeevdv\yii\shortcodes\ShortcodeBehavior::class,
            'map' => [
                'gallery' => [
                    'class' => \frontend\widgets\dynamic\GalleryWidget::class,
                ]
                ,'low_banner' => [
                    'class' => \frontend\widgets\dynamic\LowBannerWidget::class,
                ],
                'shop_banner' => [
                    'class' => \frontend\widgets\dynamic\ShopBannerWidget::class,
                ],
                'info_block' => [
                    'class' => \frontend\widgets\dynamic\InfoBlockWidget::class,
                ],
                'last_news' => [
                    'class' => \frontend\widgets\dynamic\LastNewsWidget::class
                ],
                'tabs_content' => [
                    'class' => \frontend\widgets\dynamic\LastNewsWidget::class
                ],
                'tabs' => [
                    'class' => \frontend\widgets\dynamic\CompositeWidget::class,
                    'type' => \frontend\widgets\dynamic\CompositeWidget::TYPE_TABS
                ],
                'accordion' => [
                    'class' => \frontend\widgets\dynamic\CompositeWidget::class,
                    'type' => \frontend\widgets\dynamic\CompositeWidget::TYPE_ACCORDION
                ],
                'tile' => [
                    'class' => \frontend\widgets\dynamic\TileWidget::class,
                ],
                'slider_tile' => [
                    'class' => \frontend\widgets\dynamic\SliderTileWidget::class,
                ],
                'images_tile_widget' => [
                    'class' => \frontend\widgets\dynamic\Widget::class
                ],
            ],*/

            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
