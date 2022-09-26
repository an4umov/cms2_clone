<?php

namespace backend\controllers;

use Yii;
use common\models\FormSended;
use common\models\search\FormSendedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FormSendedController implements the CRUD actions for FormSended model.
 */
class FormSendedController extends Controller
{
    /**
     * Lists all FormSended models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FormSendedSearch();
        $data = Yii::$app->request->queryParams;
        $formID = !empty($data['FormSendedSearch']['form_id']) ? $data['FormSendedSearch']['form_id'] : null;
        $dataProvider = $searchModel->search($formID);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'formID' => $formID,
        ]);
    }

    /**
     * Displays a single FormSended model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the FormSended model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormSended the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FormSended::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
