<?php

namespace backend\modules\parsing\controllers;

use backend\models\form\ContentBlockForm;
use backend\models\form\LrPartsRubricBlockForm;
use common\components\helpers\BlockHelper;
use common\components\helpers\ParserHelper;
use common\models\Articles;
use common\models\ParserLrpartsRubricsBlock;
use yii\web\UploadedFile;
use common\models\ParserLrpartsItems;
use common\models\ParserLrpartsRubrics;
use common\models\search\ParserLrpartsItemsSearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `parsing` module
 */
class LrpartsController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);
        $isAjax = Yii::$app->request->isAjax;

        if (!$isAjax) {
            throw new BadRequestHttpException('Only AJAX');
        }

        $searchModel = new ParserLrpartsItemsSearch();
        $searchModel->rubric_id = $id;

        $params = [
            'model' => $model,
            'items' => $searchModel->search([])->getModels(),
        ];

        return $this->renderAjax('view', $params);
    }

    /**
     * @param int $pid
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionAdd(int $pid)
    {
        $parentModel = $this->findModelRubric($pid);

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Only AJAX');
        }

        $model = new ParserLrpartsRubrics();
        $model->parent_id = $parentModel->id;
        $model->is_last = true;
        $model->is_active = true;

        return $this->renderAjax('add', ['model' => $model,]);
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSettings()
    {
        $isUpdated = false;
        $updated = 0;

        if (Yii::$app->request->isPost) {
            $isProcess = (bool) Yii::$app->request->post('is_process', false);

            if ($isProcess) {
                $updated = ParserHelper::setEpcInArticles();
                $isUpdated = true;
            }
        }

        return $this->render('settings', [
            'articlesCount' => Articles::find()->count(),
            'itemsCount' => ParserLrpartsItems::find()->count(),
            'itemsMissedCount' => Articles::find()->where(['is_in_epc' => false,])->count(),
            'updated' => $updated,
            'isUpdated' => $isUpdated,
        ]);
    }

    /**
     * @param int $rid
     *
     * @return string|array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionAddItem(int $rid)
    {
        $rubricModel = $this->findModelRubric($rid);

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            $model = new ParserLrpartsItems();
            if ($model->load($post)) {
                $model->url = ParserHelper::transliterate($model->name);

                if ($model->save()) {
                    return ['ok' => true, 'rid' => $rubricModel->id, 'id' => $model->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            }
        } elseif (Yii::$app->request->isAjax){
            $model = new ParserLrpartsItems();
            $model->rubric_id = $rubricModel->id;
            $model->is_active = true;

            return $this->renderAjax('add_item', ['model' => $model,]);
        } else {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        return null;
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isGet) {
            $id = Yii::$app->request->get('id', 0);
        } else {
            $post = Yii::$app->request->post();
            $id = $post['ParserLrpartsItems']['id'] ?? 0;
        }

        if (!$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $model = $this->findModelItem($id);

        if (Yii::$app->request->isPost && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (empty($model->url)) {
                $model->url = ParserHelper::transliterate($model->name);
            }

            if ($model->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
            }
        }

        return $this->renderAjax('form', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|bool[]
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateRubric()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $id = $post['ParserLrpartsRubrics']['id'] ?? 0;

            if (!$id) {
                throw new BadRequestHttpException('Отсутствует обязательный параметр');
            }

            if (!empty($post['ParserLrpartsRubrics']['serverImage'])) {
                $pos = strpos($post['ParserLrpartsRubrics']['serverImage'], '/');
                if ($pos === 0) {
                    $post['ParserLrpartsRubrics']['serverImage'] = substr($post['ParserLrpartsRubrics']['serverImage'], 1);
                }
            }

            $model = $this->findModelRubric($id);

            if ($model->load($post)) {
                if (!empty($post['Content']['content_blocks_list'])) {
                    $model->content_blocks_list = $post['Content']['content_blocks_list'];
                }

                if (!empty($post['ParserLrpartsRubrics']['serverImage'])) {
                    $model->image = $post['ParserLrpartsRubrics']['serverImage'];
                }

                // Приоритет у файла с компа
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($imageName = $model->upload()) {
                    $model->image = $imageName;
                }

                if ($model->save()) {
                    \Yii::$app->cache->delete(ParserHelper::CACHE_KEY_LRPARTS);

                    return ['ok' => true,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            }
        }

        throw new BadRequestHttpException('Неверный запрос на обновление рубрики');
    }

    /**
     * @return array|bool[]
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteRubric()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $id = $post['id'] ?? 0;

            if (!$id) {
                throw new BadRequestHttpException('Отсутствует обязательный параметр');
            }

            $model = $this->findModelRubric($id);

            $searchModel = new ParserLrpartsItemsSearch();
            $searchModel->rubric_id = $id;
            $itemsCount = $searchModel->search([])->getTotalCount();

            if ($model->is_last && empty($itemsCount)) {
                if ($model->delete()) {
                    \Yii::$app->cache->delete(ParserHelper::CACHE_KEY_LRPARTS);
                    return ['ok' => true,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка удаления: '.print_r($model->getFirstErrors(), true),];
                }
            } else {
                return ['ok' => false, 'message' => 'Данную рубрику невозможно удалить',];
            }
        }

        throw new BadRequestHttpException('Неверный запрос на обновление рубрики');
    }

    /**
     * @return array|bool[]
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteItem()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $id = $post['id'] ?? 0;

            if (!$id) {
                throw new BadRequestHttpException('Отсутствует обязательный параметр');
            }

            $model = $this->findModelItem($id);

            if ($model->delete()) {
                \Yii::$app->cache->delete(ParserHelper::CACHE_KEY_LRPARTS);
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка удаления: '.print_r($model->getFirstErrors(), true),];
            }
        }

        throw new BadRequestHttpException('Неверный запрос на обновление товара');
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionAddRubric()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            if (!empty($post['ParserLrpartsRubrics']['serverImage'])) {
                $pos = strpos($post['ParserLrpartsRubrics']['serverImage'], '/');
                if ($pos === 0) {
                    $post['ParserLrpartsRubrics']['serverImage'] = substr($post['ParserLrpartsRubrics']['serverImage'], 1);
                }
            }

            $model = new ParserLrpartsRubrics();

            if ($model->load($post)) {
                $model->path = ParserHelper::transliterate($model->name);
                $model->is_last = true;

                if (!empty($post['ParserLrpartsRubrics']['serverImage'])) {
                    $model->image = $post['ParserLrpartsRubrics']['serverImage'];
                }

                if ($model->save()) {
                    // Приоритет у файла с компа
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    if ($imageName = $model->upload()) {
                        $model->image = $imageName;
                        $model->update(false, ['image',]);
                    }

                    $parentModel = $this->findModelRubric($model->parent_id);
                    $parentModel->is_last = false;
                    $parentModel->save(false);

                    \Yii::$app->cache->delete(ParserHelper::CACHE_KEY_LRPARTS);

                    return ['ok' => true, 'id' => $model->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            }
        }

        throw new BadRequestHttpException('Неверный запрос на обновление рубрики');
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionReplace()
    {
        if (Yii::$app->request->isPost) {
            $db = \Yii::$app->db;
            $post = Yii::$app->request->post();
            $search = trim($post['search'] ?? '');
            $replace = trim($post['replace'] ?? '');

            if (!$search) {
                throw new BadRequestHttpException('Отсутствует текст поиска');
            }

            $updatedRubrics = $updatedItems = 0;
            if ($replace) {
                $rubrics = !empty($post['rubrics']) ? $post['rubrics'] : [];
                $items = !empty($post['items']) ? $post['items'] : [];

                // Rubrics
                $ids = [];
                foreach ($rubrics as $id => $value) {
                    if (!empty($value)) {
                        $ids[] = $id;
                    }
                }

                if ($ids) {
                    $replacements = [];
                    $rubrics = ParserLrpartsRubrics::find()->where(['id' => $ids,])->asArray()->all();

                    foreach ($rubrics as $rubric) {
                        $replacements[$rubric['id']] = str_replace($search, $replace, $rubric['name']);
                    }

                    foreach ($replacements as $id => $name) {
                        $updatedRubrics += $db->createCommand()->update(
                            ParserLrpartsRubrics::tableName(),
                            ['name' => $name,],
                            ['id' => $id,]
                        )->execute();
                    }
                }

                // Items
                $ids = [];
                foreach ($items as $id => $value) {
                    if (!empty($value)) {
                        $ids[] = $id;
                    }
                }

                if ($ids) {
                    $replacements = [];
                    $items = ParserLrpartsItems::find()->where(['id' => $ids,])->asArray()->all();

                    foreach ($items as $item) {
                        $replacements[$item['id']] = str_replace($search, $replace, $item['name']);
                    }

                    foreach ($replacements as $id => $name) {
                        $updatedItems += $db->createCommand()->update(
                            ParserLrpartsItems::tableName(),
                            ['name' => $name,],
                            ['id' => $id,]
                        )->execute();
                    }
                }
            }

            $rows = [
                'rubrics' => ParserLrpartsRubrics::find()->where(['ilike', 'name', $search])->asArray()->all(),
                'items' => ParserLrpartsItems::find()->where(['ilike', 'name', $search])->asArray()->all(),
            ];

            return $this->render('replace', [
                    'search' => $search,
                    'replace' => $replace,
                    'rows' => $rows,
                    'updatedRubrics' => $updatedRubrics,
                    'updatedItems' => $updatedItems,
                ]
            );
        }

        throw new BadRequestHttpException('Неверный запрос на обновление рубрики');
    }

    public function actionBlockList(int $id)
    {
        $model = $this->findModelRubric($id);

        return $this->renderAjax('list', [
            'blocks' => $model->getBlocksData($id),
            'content' => $model,
        ]);
    }

    public function actionBlockAdd()
    {
        if (Yii::$app->request->isGet) {
            $rubricID = Yii::$app->request->get('rubric_id', 0);
        } else {
            $post = Yii::$app->request->post();
            $rubricID = $post['LrPartsRubricBlockForm']['rubric_id'] ?? 0;
        }

        $model = $this->findModelRubric($rubricID);

        $form = new LrPartsRubricBlockForm();
        $form->rubric_id = $model->id;

        //        $blockIDs = $content->type === Content::TYPE_PAGE ? ContentBlock::find()->select('block_id')->where(['content_id' => $content->id,])->column() : [];
        $blockIDs = [];

        if (Yii::$app->request->isPost && $form->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($form->save()) {
                return ['ok' => true,];
            } else {
                return ['ok' => false, 'message' => 'Ошибка добавления блока', 'error' => print_r($form->getErrors(), true),];
            }
        }

        return $this->renderAjax('block_form', [
            'form' => $form,
            'blocks' => BlockHelper::getBlocks($blockIDs),
            'action' => 'add',
        ]);
    }

    public function actionBlockDelete()
    {
        $post = Yii::$app->request->post();
        $id = $post['id'] ?? 0;

        if (!$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModelRubricBlock($id)->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deleted,];
    }


    protected function findModel($id)
    {
        if (($model = ParserLrpartsRubrics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelItem($id)
    {
        if (($model = ParserLrpartsItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelRubric($id)
    {
        if (($model = ParserLrpartsRubrics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return ParserLrpartsRubricsBlock|null
     * @throws NotFoundHttpException
     */
    protected function findModelRubricBlock($id)
    {
        if (($model = ParserLrpartsRubricsBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
