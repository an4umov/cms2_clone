<?php

namespace backend\controllers;

use common\components\helpers\UserHelper;
use Yii;
use common\models\LkSettings;
use yii\web\Controller;

/**
 * LkSettingsController implements the CRUD actions for LkSettings model.
 */
class LkSettingsController extends Controller
{
    public function actionIndex()
    {
        $model = $this->findModel();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->save();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|LkSettings|\yii\db\ActiveRecord|null
     */
    protected function findModel()
    {
        return UserHelper::getLkSettings();
    }
}
