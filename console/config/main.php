<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'migrate-fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
        'migrate-rbac' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@yii/rbac/migrations',
            'migrationTable' => 'migration',
        ],
        /*'migrate-tree' => [
            'migrationPath' => '@vendor/kartik-v/yii2-tree-manager/src/migrations',
            'class' => 'yii\console\controllers\MigrateController',
        ]*/
        'migrate-amnah' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@vendor/amnah/yii2-user/migrations',
            'migrationTable' => 'migration',
        ]
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'scriptUrl' => 'http://example.com/',
        ],
    ],
    'params' => $params,
];
