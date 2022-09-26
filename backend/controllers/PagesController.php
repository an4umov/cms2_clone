<?php

namespace backend\controllers;

use common\models\ContentItem;
use Yii;
use common\models\Tile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagesController implements the CRUD actions for Tile model.
 */
class PagesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tile models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
