<?php
namespace cabinet\controllers;

use common\components\helpers\FavoriteHelper;
use common\models\PriceList;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'transport', 'chat', 'delivery', 'contractors', 'bonuses', 'balance', 'files',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
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

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionChat()
    {
        return $this->render('chat', [
        ]);
    }

    public function actionDelivery()
    {
        return $this->render('delivery', [
        ]);
    }

    public function actionTransport()
    {
        return $this->render('transport', [
        ]);
    }

    public function actionContractors()
    {
        return $this->render('contractors', [
        ]);
    }

    public function actionBonuses()
    {
        return $this->render('bonuses', [
        ]);
    }

    public function actionBalance()
    {
        return $this->render('balance', [
        ]);
    }

    public function actionFiles()
    {
        return $this->render('files', [
        ]);
    }

    public function actionFavorite()
    {
        $keys = FavoriteHelper::list();

        $models = [];
        if (!empty($keys)) {
            $query = PriceList::find();
            $query->with('article');
            $query->where([PriceList::tableName().'.key' => $keys,]);

            $models = $query->all();
        }

        return $this->render('favorite', [
            'models' => $models,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
//        echo '1 Yii::$app->user->isGuest = '.(int)Yii::$app->user->isGuest.PHP_EOL;
        Yii::$app->user->logout();
//        echo '2 Yii::$app->user->isGuest = '.(int)Yii::$app->user->isGuest.PHP_EOL;
//        exit;

        return $this->goHome();
    }
}
