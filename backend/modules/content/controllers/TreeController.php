<?php

namespace backend\modules\content\controllers;

use common\components\helpers\CartHelper;
use common\components\helpers\ParserHelper;
use common\models\Articles;
use common\models\CartSettings;
use common\models\Content;
use common\models\ContentTree;
use common\models\ContentTreeContent;
use yii\web\UploadedFile;
use common\models\ParserLrpartsItems;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TreeController extends Controller
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = null;
        $id = Yii::$app->request->get('id', 0);
        if ($id) {
            $model = $this->findContentTreeModel($id);
        }

        return $this->render('index', ['model' => $model,]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionContent(int $id)
    {
        $model = $this->findContentModel($id);
        $isAjax = Yii::$app->request->isAjax;

        if (!$isAjax) {
            throw new BadRequestHttpException('Only AJAX');
        }

        $params = [
            'model' => $model,
        ];

        return $this->renderAjax('content', $params);
    }

    /**
     * @param int $pid
     *
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionAddFolder(int $pid)
    {
        if ($pid < 0 && isset(ContentTree::TYPE_IDS[$pid])) {
            $parentModel = new ContentTree();
            $parentModel->id = $pid;
            $parentModel->parent_id = 0;
            switch ($pid) {
                case ContentTree::TYPE_PAGES_ID:
                    $parentModel->type = ContentTree::TYPE_PAGES;
                    break;
                case ContentTree::TYPE_ARTICLES_ID:
                    $parentModel->type = ContentTree::TYPE_ARTICLES;
                    break;
                case ContentTree::TYPE_NEWS_ID:
                    $parentModel->type = ContentTree::TYPE_NEWS;
                    break;
            }
            $parentModel->name = ContentTree::getTypeTitle($parentModel->type);
        } else {
            $parentModel = $this->findContentTreeModel($pid);
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            $model = new ContentTree();

            if ($model->load($post)) {
                $maxSort = (int) ContentTree::find()->where(['parent_id' => $model->parent_id,])->max('sort');
                $model->sort = $maxSort + 1;
                $model->type = $parentModel->type;

                if ($model->save()) {
                    return ['ok' => true, 'id' => $model->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения!',];
            }
        }

        $model = new ContentTree();
        $model->parent_id = $parentModel->id;
        $model->name = ContentTree::NEW_FOLDER_NAME;

        return $this->renderAjax('add_folder', ['model' => $model, 'parentModel' => $parentModel,]);
    }

    /**
     * @param int $id
     *
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionFolder(int $id)
    {
        $model = $this->findContentTreeModel($id);

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            if ($model->load($post)) {
                if ($model->save()) {
                    return ['ok' => true, 'id' => $model->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения!',];
            }
        }

        return $this->renderAjax('update_folder', ['model' => $model,]);
    }

    public function actionDeleteFolder()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id', 0);
            $model = $this->findContentTreeModel($id);
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->delete()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка удаления: '.print_r($model->getFirstErrors(), true),];
            }
        }

        throw new BadRequestHttpException('Неверный запрос');
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionDragDropContent()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $id = (int) Yii::$app->request->post('id', 0);
            $tid = (int) Yii::$app->request->post('tid', 0);
            $children = Yii::$app->request->post('children', []);

            $isContentModel = Content::find()->where(['id' => $id,])->exists();
            $isContentTreeModel = ContentTree::find()->where(['id' => $tid,])->exists();

            if (!$isContentModel || !$isContentTreeModel) {
                return ['ok' => false, 'message' => 'Не переданы параметры для перемещения контента',];
            }

            $linkModel = ContentTreeContent::find()->where(['content_id' => $id,])->one();

            if ($linkModel) {
                if ($linkModel->content_tree_id === $tid) {
                    $this->_sortChildren($children, $tid);

                    return ['ok' => true,]; //никуда перемещать не надо, сортировка
                } else {
                    $linkModel->content_tree_id = $tid;
                    if ($linkModel->save()) {
                        $this->_sortChildren($children, $tid);

                        return ['ok' => true, 'id' => $linkModel->id,];
                    } else {
                        return ['ok' => false, 'message' => 'Ошибка перемещения контента: '.print_r($linkModel->getFirstErrors(), true),];
                    }
                }
            } else {
                $maxSort = (int) ContentTreeContent::find()->where(['content_tree_id' => $tid,])->max('sort');

                $newLinkModel = new ContentTreeContent();
                $newLinkModel->content_id = $id;
                $newLinkModel->content_tree_id = $tid;
                $newLinkModel->sort = $maxSort + 1;
                if ($newLinkModel->save()) {
                    $this->_sortChildren($children, $tid);

                    return ['ok' => true, 'id' => $newLinkModel->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка перемещения контента: '.print_r($newLinkModel->getFirstErrors(), true),];
                }
            }
        }

        throw new BadRequestHttpException('Неверный запрос');
    }

    /**
     * @param array $children
     * @param int   $tid
     *
     * @throws \yii\db\Exception
     */
    private function _sortChildren(array $children, int $tid) : void
    {
        if (!empty($children)) {
            foreach ($children as $index => $contentID) {
                \Yii::$app->db->createCommand()->update(
                    ContentTreeContent::tableName(),
                    ['sort' => ($index + 1),],
                    ['content_id' => $contentID, 'content_tree_id' => $tid,]
                )->execute();
            }
        }
    }

    /**
     * @param $id
     *
     * @return ContentTree|null
     * @throws NotFoundHttpException
     */
    protected function findContentTreeModel($id)
    {
        if (($model = ContentTree::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return Content|null
     * @throws NotFoundHttpException
     */
    protected function findContentModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
