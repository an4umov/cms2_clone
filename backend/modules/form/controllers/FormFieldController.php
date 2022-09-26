<?php

namespace backend\modules\form\controllers;

use common\models\FormField;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * FormFieldController implements the CRUD actions for FormField model.
 */
class FormFieldController extends Controller
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
        $model = new FormField();
        $rows = FormField::find()->where(['form_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

        foreach ($rows as $row) {
            $items[$row['id']] = ['content' => '<div class="pull-left">'.$row['sort'].'. '.$row['name'].' / <span class="badge badge-primary">'.$model->getTypeTitle($row['type']).'</span></div> '.
                '<div class="pull-right"><a href="#" class="form-field-form-field-edit" title="Редактировать" data-id="'.$row['id'].'" data-form_id="'.$row['form_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> '.
                '<a href="#" title="Удалить" class="form-field-form-field-delete" data-id="'.$row['id'].'" data-form_id="'.$row['form_id'].'"><span class="glyphicon glyphicon-trash"></span></a></div>',];
        }

        return $this->renderAjax('list', [
            'items' => $items,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $formID = Yii::$app->request->get('form_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $formID = $post['FormField']['form_id'] ?? 0;
        }

        if (!$formID) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = new FormField();
        $model->form_id = $formID;

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = !empty($post['FormField']['data']) ? $post['FormField']['data'] : [];
            $model->setData($data);

            $maxSort = (int) FormField::find()->where(['form_id' => $model->form_id, 'deleted_at' => null,])->max('sort');
            $model->sort = $maxSort + 1;

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getErrors(), true),];
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
            $formID = Yii::$app->request->get('form_id', 0);
            $id = Yii::$app->request->get('id', 0);
        } else {
            $post = Yii::$app->request->post();
            $formID = $post['FormField']['form_id'] ?? 0;
            $id = $post['FormField']['id'] ?? 0;
        }

        if (!$formID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = $this->findModelByForm($id, $formID);

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = !empty($post['FormField']['data']) ? $post['FormField']['data'] : [];
            $model->setData($data);

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
        $formID = $post['form_id'] ?? 0;
        $id = $post['id'] ?? 0;

        if (!$formID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModelByForm($id, $formID)->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deleted,];
    }

    /**
     * @param $id
     *
     * @return FormField|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = FormField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @param int $formID
     *
     * @return FormField
     * @throws NotFoundHttpException
     */
    protected function findModelByForm(int $id, int $formID) : FormField
    {
        if (($model = FormField::findOne(['id' => $id, 'form_id' => $formID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
