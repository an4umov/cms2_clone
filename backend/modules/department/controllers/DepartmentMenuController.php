<?php

namespace backend\modules\department\controllers;

use common\components\helpers\DepartmentHelper;
use common\models\DepartmentMenuTag;
use common\models\DepartmentMenuTagList;
use common\models\DepartmentModelList;
use common\models\search\DepartmentMenuTagListSearch;
use common\models\search\DepartmentMenuTagSearch;
use common\models\search\DepartmentModelListSearch;
use Yii;
use common\models\DepartmentMenu;
use common\models\search\DepartmentMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepartmentMenuController implements the CRUD actions for DepartmentMenu model.
 */
class DepartmentMenuController extends Controller
{
    /**
     * Lists all DepartmentMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new DepartmentMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isAjax = Yii::$app->request->isAjax;
        $id = Yii::$app->request->get('id', 0);

        $model = new DepartmentMenu();
        if ($id) {
            $model->department_id = $id;
        }

        $maxSort = (int) DepartmentMenu::find()->max('sort');
        $model->sort = $maxSort + 1;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->is_all_products) {
                DepartmentMenu::updateAll(['is_all_products' => false,], 'id != :id AND department_id = :department_id', [':id' => $model->id, ':department_id' => $model->department_id,]);
            }

            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU,]);
            }

            return $id ? $this->redirect(['/department/department-model/update', 'id' => $id,]) : $this->redirect(['index',]);
        }

        $params = ['model' => $model, 'isAjax' => $isAjax,];
        if ($isAjax) {
            return $this->renderAjax('create', $params);
        }

        return $this->render('create', $params);
    }

    public function actionCreateTag($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $owner = $this->findModel($id);

        $model = new DepartmentMenuTag();
        $model->department_menu_id = $id;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->departmentMenu->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU_TAG,]);
            }

            return $this->redirect(['update', 'id' => $owner->id]);
        }

        $params = ['model' => $model, 'owner' => $owner, 'isAjax' => $isAjax,];
        if ($isAjax) {
            return $this->renderAjax('create-tag', $params);
        }

        return $this->render('create-tag', $params);
    }
/*
    public function actionCreateTagList($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $owner = $this->findMenuTag($id);

        $model = new DepartmentMenuTagList();
        $model->department_menu_tag_id = $id;
        $maxSort = (int) DepartmentMenuTagList::find()->where(['department_menu_tag_id' => $model->department_menu_tag_id,])->max('sort');
        $model->sort = $maxSort + 1;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->departmentMenuTag->departmentMenu->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU_TAG_LIST,]);
            }

            return $this->redirect(['update-tag', 'id' => $owner->id]);
        }

        $params = ['model' => $model, 'owner' => $owner, 'isAjax' => $isAjax,];
        if ($isAjax) {
            return $this->renderAjax('create-tag-list', $params);
        }

        return $this->render('create-tag-list', $params);
    }
*/
    /**
     * Updates an existing DepartmentMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $did = Yii::$app->request->get('did', 0);
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->landing_page_type === DepartmentMenu::LANDING_PAGE_TYPE_PAGE) {
                if (!empty($model->landing_page_catalog)) {
                    $model->landing_page_catalog = null;
                    $model->save(false);
                }
            } elseif ($model->landing_page_type === DepartmentMenu::LANDING_PAGE_TYPE_CATALOG) {
                if (!empty($model->landing_page_id)) {
                    $model->landing_page_id = null;
                    $model->save(false);
                }
            } else {
                $model->landing_page_catalog = null;
                $model->landing_page_id = null;
                $model->save(false);
            }

            if ($model->is_all_products) {
                DepartmentMenu::updateAll(['is_all_products' => false,], 'id != :id AND department_id = :department_id', [':id' => $model->id, ':department_id' => $model->department_id,]);
            }

            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU,]);
            }

            return $did ? $this->redirect(['/department/department/update', 'id' => $did,]) : $this->redirect(['index',]);
        }

        $searchModel = new DepartmentMenuTagSearch();
        $searchModel->department_menu_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isAjax' => $isAjax,
        ];
        if ($isAjax) {
            return $this->renderAjax('update', $params);
        }

        return $this->render('update', $params);
    }

    public function actionUpdateTag($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $model = $this->findMenuTag($id);
        $owner = $this->findModel($model->department_menu_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->departmentMenu->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU_TAG,]);
            }

            return $this->redirect(['update', 'id' => $owner->id]);
        }

        $searchModel = new DepartmentMenuTagListSearch();
        $searchModel->department_menu_tag_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = [
            'model' => $model,
            'owner' => $owner,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isAjax' => $isAjax,
        ];
        if ($isAjax) {
            return $this->renderAjax('update-tag', $params);
        }

        return $this->render('update-tag', $params);
    }
/*
    public function actionUpdateTagList($id)
    {
        $isAjax = Yii::$app->request->isAjax;
        $model = $this->findMenuTagList($id);
        $owner = $this->findMenuTag($model->department_menu_tag_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isTree = Yii::$app->request->post('is_tree', 0);
            if ($isTree) {
                return $this->redirect(['/structures/department-tree', 'id' => $model->departmentMenuTag->departmentMenu->department_id, 'oid' => $model->id, 'otype' => DepartmentHelper::TYPE_MENU_TAG_LIST,]);
            }

            return $this->redirect(['update-tag', 'id' => $owner->id]);
        }

        $params = [
            'model' => $model,
            'owner' => $owner,
            'isAjax' => $isAjax,
        ];
        if ($isAjax) {
            return $this->renderAjax('update-tag-list', $params);
        }

        return $this->render('update-tag-list', $params);
    }
*/
    /**
     * Finds the DepartmentMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DepartmentMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DepartmentMenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return DepartmentMenuTag|null
     * @throws NotFoundHttpException
     */
    protected function findMenuTag($id)
    {
        if (($model = DepartmentMenuTag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return DepartmentMenuTagList|null
     * @throws NotFoundHttpException
     */
    protected function findMenuTagList($id)
    {
        if (($model = DepartmentMenuTagList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
