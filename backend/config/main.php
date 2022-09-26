<?php
use \backend\components\helpers\MenuHelper;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'LR-CMS',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'class' => 'amnah\yii2\user\components\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '/treemanager/node/save' => '/node/save',
                '/treemanager/node/move' => '/node/move',
                '/users' => 'user/admin/index',
                '/users/<action:\w+>' => 'user/admin/<action>',
                '/'.MenuHelper::FIRST_MENU_CONTENT => MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_PAGES,

                '/'.MenuHelper::FIRST_MENU_PARSING => MenuHelper::FIRST_MENU_PARSING.'/'.MenuHelper::SECOND_MENU_PARSING_LRPARTS,

                '/'.MenuHelper::FIRST_MENU_STRUCTURES => MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TREE,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT => MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT => '/'.MenuHelper::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TREE => MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TREE,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_MENU => MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT.'/'.MenuHelper::SECOND_MENU_STRUCTURES_MENU,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TAG => MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT.'/'.MenuHelper::SECOND_MENU_STRUCTURES_TAG,
                '/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_REFERENCE => MenuHelper::SECOND_MENU_STRUCTURES_REFERENCE,
                '/'.MenuHelper::FIRST_MENU_REFERENCES.'/'.MenuHelper::SECOND_MENU_REFERENCES_REFERENCE => MenuHelper::SECOND_MENU_STRUCTURES_REFERENCE,

                '/'.MenuHelper::SECOND_MENU_SETTINGS_MACRO => '/'.MenuHelper::FIRST_MENU_SETTINGS.'/'.MenuHelper::SECOND_MENU_SETTINGS_MACRO,

                '/'.MenuHelper::FIRST_MENU_ADMIN => '/'.MenuHelper::SECOND_MENU_ADMIN_MANAGERS,

                '/'.MenuHelper::FIRST_MENU_SETTINGS => '/'.MenuHelper::FIRST_MENU_SETTINGS.'/'.MenuHelper::SECOND_MENU_SETTINGS_NEWS,
                '/'.MenuHelper::FIRST_MENU_SETTINGS.'/'.MenuHelper::SECOND_MENU_SETTINGS_LK => '/lk-settings',
                '/'.MenuHelper::FIRST_MENU_SETTINGS.'/'.MenuHelper::SECOND_MENU_SETTINGS_MAILING => '/lk-mailing',
                '/'.MenuHelper::FIRST_MENU_SETTINGS.'/'.MenuHelper::SECOND_MENU_SETTINGS_GREEN_MENU => '/green-menu',

                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_GALLERY,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_GALLERY => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_GALLERY,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_TEXT => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_TEXT,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_BANNER => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_BANNER,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_SLIDER => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_SLIDER,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_FILTER => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_FILTER,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_AGGREGATOR => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_AGGREGATOR,
                '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_COMMON.'/'.MenuHelper::THIRD_MENU_BLOCKS_SETTING => '/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::THIRD_MENU_BLOCKS_SETTING,
            ],
        ],

        'view' => [
            'theme' => [
                'pathMap' => [
                    //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                    '@app/views' => '@backend/views/adminlte',
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
        'imagemanager' => [
            'class' => 'noam148\imagemanager\components\ImageManagerGetPath',
            //set media path (outside the web folder is possible)
            'mediaPath' => '../../files',
            //path relative web folder. In case of multiple environments (frontend, backend) add more paths
            'cachePath' =>  ['assets/images', '../../frontend/web/assets/images'],
            //use filename (seo friendly) for resized images else use a hash
            'useFilename' => true,
            //show full url (for example in case of a API)
            'absoluteUrl' => false,
            'databaseComponent' => 'db' // The used database component by the image manager, this defaults to the Yii::$app->db component
        ],
    ],
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/path/to/uploadfolder',
            'uploadUrl' => '@web/path/to/uploadfolder',
            'imageAllowExtensions'=>['jpg','png','gif',],
        ],
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
            'modelClasses' => [
                'UserSearch' => \backend\models\UserSearch::class,
            ],
            'controllerMap' => [
                'admin' => \backend\controllers\UserController::class,
            ],
            'loginRedirect' => '/',
        ],

        'articles' => [
            'class' => 'backend\modules\articles\OldLrArticlesModule',
        ],

        'blocks' => [
            'class' => 'backend\modules\blocks\BlocksModule',
            'defaultRoute' => 'gallery',
        ],

        'content' => [
            'class' => 'backend\modules\content\ContentModule',
            'defaultRoute' => 'page',
        ],

        'references' => [
            'class' => 'backend\modules\references\ReferencesModule',
            'defaultRoute' => 'partner',
        ],

        'department' => [
            'class' => 'backend\modules\department\DepartmentModule',
            'defaultRoute' => 'department',
        ],

        'parsing' => [
            'class' => 'backend\modules\parsing\ParsingModule',
            'defaultRoute' => 'lrparts',
        ],

        'cart' => [
            'class' => 'backend\modules\cart\CartModule',
            'defaultRoute' => 'cart-settings',
        ],

        'reference' => [
            'class' => 'backend\modules\reference\ReferenceModule',
            'defaultRoute' => 'reference',
        ],

        'form' => [
            'class' => 'backend\modules\form\FormModule',
            'defaultRoute' => 'form',
        ],

        'imagemanager' => [
            'class' => 'noam148\imagemanager\Module',
            //set accces rules ()
            'canUploadImage' => true,
            'canRemoveImage' => function(){
                return true;
            },
            'deleteOriginalAfterEdit' => false, // false: keep original image after edit. true: delete original image after edit
            // Set if blameable behavior is used, if it is, callable function can also be used
            'setBlameableBehavior' => false,
            //add css files (to use in media manage selector iframe)
            'cssFiles' => [
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css',
            ],
        ],

        'filemanager' => [
            'class' => 'pendalf89\filemanager\Module',
            // Upload routes
            'routes' => [
                // Base absolute path to web directory
                'baseUrl' => __DIR__ . '/../web/img/lr',
                // Base web directory url
                'basePath' => '@backend/web/img/lr',
                // Path for uploaded files in web directory
                'uploadPath' => 'uploads',
            ],
            // Thumbnails info
            'thumbs' => [
                'small' => [
                    'name' => 'Мелкий',
                    'size' => [100, 100],
                ],
                'medium' => [
                    'name' => 'Средний',
                    'size' => [300, 200],
                ],
                'large' => [
                    'name' => 'Большой',
                    'size' => [500, 400],
                ],
            ],
        ],
    ],
    'params' => $params,
    'language' => 'ru-RU',
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
];
