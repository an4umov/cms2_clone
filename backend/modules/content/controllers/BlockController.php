<?php

namespace backend\modules\content\controllers;

use Yii;
use backend\models\form\ContentBlockForm;
use common\components\helpers\BlockHelper;
use common\models\Content;
use common\models\ContentBlock;
use common\models\Block;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class BlockController extends Controller
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
        $content = $this->findContentModel($id);
        $expanded = Yii::$app->request->get('expanded', []);
        if (!empty($expanded)) {
            $expanded = explode(',', $expanded);
        }

        return $this->renderAjax('list', [
            'blocks' => $content->getBlocksData(),
            'expanded' => $expanded,
            'content' => $content,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            $contentID = Yii::$app->request->get('content_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $contentID = $post['ContentBlockForm']['content_id'] ?? 0;
        }

        $content = $this->findContentModel($contentID);
        $model = new ContentBlockForm();
        $model->content_id = $content->id;
        $model->contentType = $content->type;

//        $blockIDs = $content->type === Content::TYPE_PAGE ? ContentBlock::find()->select('block_id')->where(['content_id' => $content->id,])->column() : [];
        $blockIDs = [];

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка добавления блока', 'error' => print_r($model->getErrors(), true),];
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
            'blocks' => BlockHelper::getBlocks($blockIDs),
            'action' => 'add',
        ]);
    }

    public function actionAddSetting()
    {
        if (Yii::$app->request->isGet) {
            $contentID = Yii::$app->request->get('content_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $contentID = $post['ContentBlockForm']['content_id'] ?? 0;
        }

        $content = $this->findContentModel($contentID);

        $model = new ContentBlockForm();
        $model->content_id = $content->id;
        $model->type = Content::TYPE_SETTING;
        $model->contentType = $content->type;

        $blockIDs = ContentBlock::find()->select('block_id')->where(['content_id' => $content->id,])->column();

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка добавления блока',];
            }
        }

        return $this->renderAjax('form_setting', [
            'model' => $model,
            'blocks' => BlockHelper::getBlocks($blockIDs),
            'action' => 'add-setting',
        ]);
    }

    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        $id = $post['id'] ?? 0;

        if (!$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModel($id)->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deleted,];
    }

    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     *
     * @return ContentBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = ContentBlock::findOne(['id' => $id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @param int $blockID
     *
     * @return ContentBlock
     * @throws NotFoundHttpException
     */
    protected function findModelByBlock(int $id, int $blockID) : ContentBlock
    {
        if (($model = ContentBlock::findOne(['id' => $id, 'block_id' => $blockID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @param int $contentID
     *
     * @return ContentBlock
     * @throws NotFoundHttpException
     */
    protected function findModelByContent(int $id, int $contentID) : ContentBlock
    {
        if (($model = ContentBlock::findOne(['id' => $id, 'content_id' => $contentID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $contentID
     *
     * @return Content
     * @throws NotFoundHttpException
     */
    protected function findContentModel(int $contentID) : Content
    {
        if (($model = Content::findOne(['id' => $contentID,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
