<?php

namespace backend\modules\reference\controllers;

use Yii;
use common\models\ReferenceValue;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ReferenceValueController implements the CRUD actions for ReferenceValue model.
 */
class ReferenceValueController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionList(int $id)
    {
        $items = [];
        $rows = ReferenceValue::find()->where(['reference_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

        foreach ($rows as $row) {
            $items[$row['id']] = ['content' => '<div class="pull-left">'.$row['sort'].'. '.$row['name'].'</div> '.
                '<div class="pull-right"><a href="#" class="reference-value-form-field-edit" title="Редактировать" data-id="'.$row['id'].'" data-reference_id="'.$row['reference_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> '.
                '<a href="#" title="Удалить" class="reference-value-form-field-delete" data-id="'.$row['id'].'" data-reference_id="'.$row['reference_id'].'"><span class="glyphicon glyphicon-trash"></span></a></div>',];
        }

        return $this->renderAjax('list', [
            'items' => $items,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $referenceID = Yii::$app->request->get('reference_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $referenceID = $post['ReferenceValue']['reference_id'] ?? 0;
        }

        if (!$referenceID) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = new ReferenceValue();
        $model->reference_id = $referenceID;

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $maxSort = (int) ReferenceValue::find()->where(['reference_id' => $model->reference_id, 'deleted_at' => null,])->max('sort');
            $model->sort = $maxSort + 1;

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
            'action' => 'add',
        ]);
    }

    /**
     * @return array|string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isGet) {
            $referenceID = Yii::$app->request->get('reference_id', 0);
            $id = Yii::$app->request->get('id', 0);
        } else {
            $post = Yii::$app->request->post();
            $referenceID = $post['ReferenceValue']['reference_id'] ?? 0;
            $id = $post['ReferenceValue']['id'] ?? 0;
        }

        if (!$referenceID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = $this->findModelByReference($id, $referenceID);

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
            'action' => 'update',
        ]);
    }

    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        $referenceID = $post['reference_id'] ?? 0;
        $id = $post['id'] ?? 0;

        if (!$referenceID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModelByReference($id, $referenceID)->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deleted,];
    }

    /**
     * Finds the ReferenceValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReferenceValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReferenceValue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @param int $referenceID
     *
     * @return ReferenceValue
     * @throws NotFoundHttpException
     */
    protected function findModelByReference(int $id, int $referenceID) : ReferenceValue
    {
        if (($model = ReferenceValue::findOne(['id' => $id, 'reference_id' => $referenceID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
