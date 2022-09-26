<?php

namespace backend\controllers;

use common\components\helpers\CatalogHelper;
use Yii;
use yii\web\Controller;

/**
 * CatalogTreeSettingController implements the CRUD actions for CatalogTreeSetting model.
 */
class CatalogTreeSettingController extends Controller
{
    public function actionIndex()
    {
        $model = CatalogHelper::getCatalogTreeSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
