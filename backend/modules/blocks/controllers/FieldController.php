<?php

namespace backend\modules\blocks\controllers;

use common\components\helpers\BlockHelper;
use common\models\BlockField;
use common\models\BlockFieldList;
use common\models\BlockFieldValuesList;
use Yii;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class FieldController extends Controller
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

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $blockID = Yii::$app->request->get('block_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $blockID = $post['BlockField']['block_id'] ?? 0;
        }

        if (!$blockID) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = new BlockField();
        $model->block_id = $blockID;

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $maxSort = (int) BlockField::find()->where(['block_id' => $model->block_id, 'deleted_at' => null,])->max('sort');
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

    public function actionList(int $id)
    {
        $items = [];
        $rows = BlockField::find()->where(['block_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

        $model = new BlockField();
        foreach ($rows as $row) {
            $items[$row['id']] = ['content' => '<div class="pull-left">'.Html::tag('span', '', ['class' => $model->getTypeIcon($row['type'])]).' '.$row['name'].' '.Html::tag('span', $model->getTypeTitle($row['type']), ['class' => $model->getTypeClass($row['type']),]).'</div> '.
                '<div class="pull-right"><a href="#" class="block-form-field-edit" title="Редактировать" data-id="'.$row['id'].'" data-block_id="'.$row['block_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> '.
                '<a href="#" title="Удалить" class="block-form-field-delete" data-id="'.$row['id'].'" data-block_id="'.$row['block_id'].'"><span class="glyphicon glyphicon-trash"></span></a></div>',];
        }

        return $this->renderAjax('list', [
            'id' => $id,
            'items' => $items,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFieldList(int $id)
    {
        $rows = [];
        $model = new BlockField();

        if (!empty($id)) {
            $rows = BlockFieldList::find()->where(['field_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();
            $model = $this->findModel($id);
        }

        return $this->renderAjax('field_list', [
            'rows' => $rows,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFieldValuesList(int $id)
    {
        $rows = [];
        $model = new BlockField();

        if (!empty($id)) {
            $rows = BlockFieldValuesList::find()->where(['field_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();
            $model = $this->findModel($id);
        }

        return $this->renderAjax('field_values_list', [
            'rows' => $rows,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionFieldListItem(int $id) : string
    {
        $row = new BlockFieldList();
        $row->field_id = $id;

        return BlockHelper::getBlockFieldListItem($row);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionFieldListAdd(int $id) : string
    {
        $blockID = Yii::$app->request->get('block_id', 0);
        $contentBlockID = Yii::$app->request->get('content_block_id', 0);
        $length = Yii::$app->request->get('length', 0);

        $rows = BlockFieldList::find()->where(['field_id' => $id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();

        return $this->renderAjax('field_list_add', [
            'blockID' => $blockID,
            'contentBlockID' => $contentBlockID,
            'rows' => $rows,
            'sort' => ++$length,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionFieldValuesListItem(int $id) : string
    {
        $row = new BlockFieldValuesList();
        $row->field_id = $id;

        return BlockHelper::getBlockFieldValuesListItem($row);
    }

    /**
     * @param string         $name
     * @param BlockFieldList $model
     *
     * @return string
     */
    private function _getTypeDropDown(string $name, BlockFieldList $model) : string
    {
        return Html::dropDownList($name, 'type', $model->getTypeOptions());
    }

    /**
     * @return array|string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isGet) {
            $blockID = Yii::$app->request->get('block_id', 0);
            $id = Yii::$app->request->get('id', 0);
        } else {
            $post = Yii::$app->request->post();
            $blockID = $post['BlockField']['block_id'] ?? 0;
            $id = $post['BlockField']['id'] ?? 0;
        }

        if (!$blockID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = $this->findModelByBlock($id, $blockID);

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

//            return $model->list;

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
        $blockID = $post['block_id'] ?? 0;
        $id = $post['id'] ?? 0;

        if (!$blockID && !$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModelByBlock($id, $blockID)->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deleted,];
    }

    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     *
     * @return BlockField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = BlockField::findOne(['id' => $id, 'deleted_at' => null,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @param int $blockID
     *
     * @return BlockField
     * @throws NotFoundHttpException
     */
    protected function findModelByBlock(int $id, int $blockID) : BlockField
    {
        if (($model = BlockField::findOne(['id' => $id, 'block_id' => $blockID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
