<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

class TestController extends Controller
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

    public function actionTest()
    {
        $request = Yii::$app->getRequest();
        $myData = (object)$request->bodyParams['myData'];

        var_dump($myData);
        exit;

        // Далее что-то делаем с полученными данными
        return $this->asJson($myResult);
    }
}