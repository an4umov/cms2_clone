<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => 'identity', 'httpOnly' => true],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii/messages',
                ],
                'lr' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'lr' => 'lr.php',
                        'lr/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'formatter' => [
            'locale' => 'ru',//'ru-RU',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'ssl://smtp.yandex.com',
            //    'username' => 'madseller',
            //    'password' => 'hjatwktjnjmatvpr',
            //     'port' => '465',
            //     //'encryption' => 'SSL', //'tls',

            'class' => 'Swift_SmtpTransport',
            'host' => '127.0.0.1',
            //                'username' => 'goodvisor.com',
            //                'password' => 'dzNpQGHmqgt5YaKd',
            'port' => '25',
            'encryption' => false, //'tls',
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            'modelClasses' => [
                'User' => \common\models\User::class,
                'Profile' => \common\models\Profile::class,
                'UserToken' => \common\models\UserToken::class,
                'LoginForm' => \common\models\LoginForm::class,
            ]
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
    ],
];
