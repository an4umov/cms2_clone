<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
//    public $modelClass = 'common\models\PriceList';

//    public function behaviors()
//    {
//        // удаляем rateLimiter, требуется для аутентификации пользователя
//        $behaviors = parent::behaviors();
//        unset($behaviors['rateLimiter']);
//
//        return $behaviors;
//    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false, 'message' => 'Hello world',];

        return $response;
    }
}