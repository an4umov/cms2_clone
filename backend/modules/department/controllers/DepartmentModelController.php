<?php

namespace backend\modules\department\controllers;

use common\components\helpers\DepartmentHelper;
use common\models\DepartmentModelList;
use common\models\search\DepartmentMenuSearch;
use common\models\search\DepartmentModelListSearch;
use Yii;
use common\models\DepartmentModel;
use common\models\search\DepartmentModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * DepartmentModelController implements the CRUD actions for DepartmentModel model.
 */
class DepartmentModelController extends Controller
{
    /**
     * Lists all DepartmentModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new DepartmentModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isAjax = Yii::$app->request->isAjax;
        $id = Yii::$app->request->get('id', 0);
        $model = new DepartmentModel();
        if ($id) {
            $model->department_id = $id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MODEL,]);
            }

            return $id ? $this->redirect(['/department/department/update', 'id' => $id,]) : $this->redirect(['index',]);
        }

        $params = ['model' => $model, 'isAjax' => $isAjax,];
        if ($isAjax) {
            return $this->renderAjax('create', $params);
        }

        return $this->render('create', $params);
    }

    public function actionCreateList($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $owner = $this->findModel($id);

        $model = new DepartmentModelList();
        $model->department_model_id = $id;

        $maxSort = (int) DepartmentModelList::find()->where(['department_model_id' => $model->department_model_id,])->max('sort');
        $model->sort = $maxSort + 1;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $owner->id]);
        }

        return $this->render('create-list', [
            'model' => $model,
            'owner' => $owner,
            'isAjax' => $isAjax,
        ]);
    }

    /**
     * Updates an existing DepartmentModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MODEL,]);
            }

            $did = Yii::$app->request->get('did', 0);

            return $did ? $this->redirect(['/department/department/update', 'id' => $did,]) : $this->redirect(['index',]);
        }

        $searchModel = new DepartmentModelListSearch();
        $searchModel->department_model_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchMenuModel = new DepartmentMenuSearch();
        $searchMenuModel->department_model_id = $id;
        $dataProviderMenu = $searchMenuModel->search([]);

        $params = [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderMenu' => $dataProviderMenu,
            'isAjax' => $isAjax,
        ];
        if ($isAjax) {
            return $this->renderAjax('update', $params);
        }

        return $this->render('update', $params);
    }

    public function actionUpdateList($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $model = $this->findModelList($id);
        $owner = $this->findModel($model->department_model_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $owner->id]);
        }

        return $this->render('update-list', [
            'model' => $model,
            'owner' => $owner,
            'isAjax' => $isAjax,
        ]);
    }

    /**
     * Finds the DepartmentModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DepartmentModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DepartmentModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return DepartmentModelList|null
     * @throws NotFoundHttpException
     */
    protected function findModelList($id)
    {
        if (($model = DepartmentModelList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
