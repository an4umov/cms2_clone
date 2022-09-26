<?php

namespace backend\controllers;

use Yii;
use common\models\GreenMenu;
use common\models\search\GreenMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GreenMenuController implements the CRUD actions for GreenMenu model.
 */
class GreenMenuController extends Controller
{
    /**
     * Lists all GreenMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GreenMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GreenMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GreenMenu();

        $maxSort = (int) GreenMenu::find()->max('sort');
        $model->sort = $maxSort + 1;
        $model->is_enabled = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GreenMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the GreenMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GreenMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GreenMenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
