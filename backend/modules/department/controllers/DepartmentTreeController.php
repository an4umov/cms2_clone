<?php

namespace backend\modules\department\controllers;

use common\components\helpers\DepartmentHelper;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use Yii;
use common\models\search\DepartmentModelSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * DepartmentTreeController implements the CRUD actions for DepartmentModel model.
 */
class DepartmentTreeController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id', 0);
        $oid = Yii::$app->request->get('oid', 0);
        $otype = Yii::$app->request->get('otype', DepartmentHelper::TYPE_DEPARTMENT);

        $model = null;
        if ($id) {
            $model = $this->findModel($id);
        }

        if ($otype === DepartmentHelper::TYPE_DEPARTMENT) {
            $oid = $id;
        }

        return $this->render('index', [
            'model' => $model,
            'oid' => $oid,
            'otype' => $otype,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $oid = Yii::$app->request->get('oid', 0);
        $otype = Yii::$app->request->get('otype', '');

        return $this->render('view', [
            'model' => $model,
            'oid' => $oid,
            'otype' => $otype,
        ]);
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Неверный запрос');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ['ok' => false, 'message' => '',];
        $id = Yii::$app->request->post('id', 0);
        $type = Yii::$app->request->post('type', '');

//        return ['ok' => true, 'message' => 'SAFdsf sdfsdf sdf', 'type' => $type, 'id' => $id,];

        if ($type === DepartmentHelper::TYPE_DEPARTMENT) {
            $model = Department::findOne($id);
            if ($model) {
                $result['ok'] = $model->delete();
            } else {
                $result['message'] = 'Не найден департамент, ID = '.$id;
            }
        } elseif ($type === DepartmentHelper::TYPE_MENU) {
            $model = DepartmentMenu::findOne($id);
            if ($model) {
                $result['ok'] = $model->delete();
            } else {
                $result['message'] = 'Не найден пункт меню, ID = '.$id;
            }
        } elseif ($type === DepartmentHelper::TYPE_MENU_TAG) {
            $model = DepartmentMenuTag::findOne($id);
            if ($model) {
                $result['ok'] = $model->delete();
            } else {
                $result['message'] = 'Не найдена тематика, ID = '.$id;
            }
        } else {
            $result['message'] = 'Неправильный тип';
        }

        return $result;
    }

    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
