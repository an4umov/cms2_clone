<?php
namespace cabinet\controllers;

use common\components\helpers\DaDataHelper;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Delivery controller
 */
class DataController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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

    public function actionFind()
    {
        $address = Yii::$app->request->get('address', '');

        $dadata = new DaDataHelper();
        $dadata->init();

        $result = [];
        if (!empty($address)) {
            $result = $dadata->findByAddress($address);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    public function actionSuggest()
    {
        $name = Yii::$app->request->get('name', '');

        $dadata = new DaDataHelper();
        $dadata->init();

        $result = [];
        if (!empty($name)) {
            $result = $dadata->suggest($name);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    public function actionFindById()
    {
        $bik = Yii::$app->request->get('bik', '');

        $dadata = new DaDataHelper();
        $dadata->init();

        $result = [];
        if (!empty($bik)) {
            $result = $dadata->findById($bik);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

}
