<?php

namespace backend\modules\references\controllers;

use common\models\ParserProverkacheka;
use common\models\search\ParserProverkachekaSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ProverkachekaController
 *
 * @package backend\modules\references\controllers
 */
class ProverkachekaController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ParserProverkachekaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     *
     * @return ParserProverkacheka|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ParserProverkacheka::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
