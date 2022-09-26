<?php

namespace backend\controllers;

use common\models\SettingsFooter;
use Yii;
use common\models\SettingsFooterItem;
use common\models\search\SettingsFooterItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsFooterItemController implements the CRUD actions for SettingsFooterItem model.
 */
class SettingsFooterItemController extends Controller
{
    /**
     * Displays a single SettingsFooterItem model.
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
     * @param int $footer_id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate(int $footer_id)
    {
        $model = new SettingsFooterItem();
        $footerModel = $this->findFooterModel($footer_id);
        $model->footer_id = $footerModel->id;
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/settings-footer/update', 'id' => $footerModel->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'footerModel' => $footerModel,
        ]);
    }

    /**
     * Updates an existing SettingsFooterItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/settings-footer/update', 'id' => $model->footer_id,]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the SettingsFooterItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingsFooterItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SettingsFooterItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return SettingsFooter|null
     * @throws NotFoundHttpException
     */
    protected function findFooterModel($id)
    {
        if (($model = SettingsFooter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
