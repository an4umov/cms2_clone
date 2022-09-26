<?php

namespace backend\modules\department\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\components\helpers\DepartmentHelper;
use common\models\BlockField;
use common\models\Catalog;
use common\models\search\DepartmentMenuSearch;
use common\models\search\DepartmentModelSearch;
use Yii;
use common\models\Department;
use common\models\search\DepartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
{
    /**
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();
        $isAjax = Yii::$app->request->isAjax;

        $maxSort = (int) Department::find()->max('sort');
        $model->sort = $maxSort + 1;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DepartmentHelper::addDefaultDepartmentMenu($model->id);

            return $this->redirect(['index',]);
        }

        return $this->render('create', [
            'model' => $model,
            'isAjax' => $isAjax,
        ]);
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $isAjax = Yii::$app->request->isAjax;

        if (Yii::$app->request->isPost) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                DepartmentHelper::addDefaultDepartmentMenu($model->id);

                if ($isTree) {
                    return $this->redirect(['/structures/department-tree', 'id' => $model->id,]);
                }

                return $this->redirect(['index',]);
            } else {
                if ($isTree) {
                    print_r($model->getErrors());exit;

                    return $this->redirect(['/structures/department-tree', 'id' => $model->id,]);
                }
            }
        }

        $searchModel = new DepartmentMenuSearch();
        $searchModel->department_id = $id;
        $dataProviderMenu = $searchModel->search([]);

        $params = [
            'model' => $model,
            'dataProviderMenu' => $dataProviderMenu,
            'isAjax' => $isAjax,
        ];
        if ($isAjax) {
            return $this->renderAjax('update', $params);
        }

        return $this->render('update', $params);
    }

    public function actionTree()
    {
        $zNodes = \common\components\helpers\DepartmentHelper::getDepartmentsTreeData();
        $zNodes = \common\components\helpers\DepartmentHelper::clearArrayKeys($zNodes);

        return $this->renderAjax('tree', [
            'zNodes' => $zNodes,
        ]);
    }

    public function actionAnalize()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            echo '<pre>';
            print_r($post);
//            exit;

            $fix = [];
            if (!empty($post['analize']) && is_array($post['analize'])) {
                foreach ($post['analize'] as $id => $value) {
                    if (!empty($value)) {
                        $fix[$id] = $id;
                    }
                }
            }

            if ($fix) {
                $rows = Catalog::find()->where(['id' => array_values($fix),])->select(['id', 'code', 'name',])->asArray()->all();

                CatalogHelper::addNewDepartmentsFromCatalog($rows);
            }

            return $this->redirect('/structures');
        }


        $notFoundGroups = $notFoundModels = [];
        $result = CatalogHelper::analyzeCatalogDepartments();

        foreach ($result['notFound'] as $item) {
            if ($item['parent_code'] === Catalog::ITEM_GROUPS_CODE) {
                $notFoundGroups[] = $item;
            } else {
                $notFoundModels[] = $item;
            }
        }

        return $this->renderAjax('analize', [
            'notFoundGroups' => $notFoundGroups,
            'notFoundModels' => $notFoundModels,
            'broken' => $result['broken'],
        ]);
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
