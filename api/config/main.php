<?php
return [
    'id' => 'centrum-api',
    'language' => 'ru-RU',
    'defaultRoute' => 'site',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    // basePath (базовый путь) приложения будет каталог `micro-app`
    'basePath' => dirname(__DIR__),
    // это пространство имен где приложение будет искать все контроллеры
    'controllerNamespace' => 'api\controllers',
    // установим псевдоним '@api', чтобы включить автозагрузку классов из пространства имен 'api'
    'bootstrap' => ['log',],
    'params' => [],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'locale' => 'ru',//'ru-RU',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=95.216.65.244;port=5432;dbname=lr_cms_test',
            'username' => 'admin',
            'password' => 'Ntktajy11',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'request' => [
            'csrfParam' => '_csrf-api',
            'cookieValidationKey' => 'dDghEjjskt62Ml2s9dd00XSy6g1IjFjwIGngf26',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
    ],
];