<?php

namespace backend\controllers;

use Yii;
use common\models\search\CatalogLinktagDepartmentSearch;
use yii\web\Controller;

/**
 * CatalogLinktagDepartmentController implements the CRUD actions for CatalogLinktagDepartment model.
 */
class CatalogLinktagDepartmentController extends Controller
{
    /**
     * Lists all CatalogLinktagDepartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogLinktagDepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
