<?php

namespace backend\controllers;

use common\components\helpers\AppHelper;
use common\models\Settings;
use Yii;
use common\models\Content;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManagersController implements the CRUD actions for Managers model.
 */
class ManagersController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
