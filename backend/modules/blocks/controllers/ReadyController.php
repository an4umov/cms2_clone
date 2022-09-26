<?php

namespace backend\modules\blocks\controllers;

use common\models\BlockField;
use common\models\BlockFieldList;
use common\models\BlockFieldValuesList;
use common\models\BlockReadyField;
use common\models\BlockReadyFieldList;
use common\models\BlockReadyFieldValuesList;
use common\models\ContentBlock;
use common\models\ContentBlockField;
use Yii;
use common\models\Block;
use common\models\BlockReady;
use common\models\search\BlockReadySearch;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;


class ReadyController extends BlockController
{
    const TYPE = Block::TYPE_BLOCK_READY;

    public function init()
    {
        parent::init();

        $this->viewPath = Yii::getAlias('@backend').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'block-ready';
    }

    public function actionIndex()
    {
        $searchModel = new BlockReadySearch();
        $searchModel->setBlockType(static::TYPE);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new BlockReady();
        $model->is_active = true;

        if ($model->load(Yii::$app->request->post()) && $model->saveModel()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel2($id);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->saveModel()) {
            return $this->redirect(['index',]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionClone($id)
    {
        $contentBlockModel = $this->findContentBlockModel($id);
        $contentBlockFieldModel = $this->findContentBlockFieldModel($id);
        $blockModel = $this->findBlockModel($contentBlockModel->block_id);

//        echo '<pre>';
//        print_r($contentBlockModel->attributes);
//        print_r($contentBlockFieldModel->attributes);
//        print_r($blockModel->attributes);

//        $blockFields = BlockField::find()->where(['block_id' => $blockModel->id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();
//        print_r($blockFields);


        $model = new BlockReady();
        $model->name = $blockModel->name;
        $model->description = $blockModel->description;
        $model->global_type = $blockModel->global_type;
        $model->is_active = true;
        $model->block_id = $blockModel->id;
        $model->setData([]);
        $oldData = $newData = [];
        if ($contentBlockFieldModel) {
            $oldData = $contentBlockFieldModel->getData();
        }

//        print_r($model->attributes);
//        exit;
        if ($model->save()) {
            $blockFields = BlockField::find()->where(['block_id' => $blockModel->id, 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

            foreach ($blockFields as $blockField) {
                $newBlockReadyField = new BlockReadyField();
                $newBlockReadyField->setAttributes($blockField);
                $newBlockReadyField->block_id = $model->id;
                $newBlockReadyField->save(false);

                if (isset($oldData[$blockField['id']])) {
                    $newData[$newBlockReadyField->id] = $oldData[$blockField['id']];
                }

                if ($blockField['type'] == BlockField::TYPE_LIST) {
                    $blockFieldLists = BlockFieldList::find()->where(['field_id' => $blockField['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

//                    echo '<pre>';
//                    print_r($newData);//exit;

                    foreach ($blockFieldLists as $blockFieldList) {
                        $newBlockReadyFieldList = new BlockReadyFieldList();
                        $newBlockReadyFieldList->setAttributes($blockFieldList);
                        $newBlockReadyFieldList->field_id = $newBlockReadyField->id;
                        $newBlockReadyFieldList->save(false);

                        if (isset($newData[$newBlockReadyField->id]) && is_array($newData[$newBlockReadyField->id])) {
                            foreach ($newData[$newBlockReadyField->id] as $index => $fieldValue) {
                                if (is_array($fieldValue) && isset($fieldValue[$blockFieldList['id']])) {
                                    $newData[$newBlockReadyField->id][$index][$newBlockReadyFieldList->id] = $fieldValue[$blockFieldList['id']];
                                    unset($newData[$newBlockReadyField->id][$index][$blockFieldList['id']]);
                                }
                            }
                        }
                    }
                } elseif ($blockField['type'] == BlockField::TYPE_VALUES_LIST) {
                    $blockFieldValuesList = BlockFieldValuesList::find()->where(['field_id' => $blockField['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->asArray()->all();

                    foreach ($blockFieldValuesList as $blockFieldValuesListItem) {
                        $newBlockReadyFieldValuesList = new BlockReadyFieldValuesList();
                        $newBlockReadyFieldValuesList->setAttributes($blockFieldValuesListItem);
                        $newBlockReadyFieldValuesList->field_id = $newBlockReadyField->id;
                        $newBlockReadyFieldValuesList->save(false);

                        if (isset($newData[$newBlockReadyField->id]) && $newData[$newBlockReadyField->id] == $blockFieldValuesListItem['id']) {
                            $newData[$newBlockReadyField->id] = $newBlockReadyFieldValuesList->id;
                        }
                    }
                }
            }

            if ($newData) {
                $model->setData($newData);
            } else {
                $model->setData([]);
            }
            $model->save(false);

            return $this->redirect(['update', 'id' => $model->id,]);
        } else {
            throw new NotFoundHttpException('Ошибка создания готового блока');
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel2($id);
        $model->is_active = false;
        $model->save(false);

        return $this->redirect(['index',]);
    }

    /**
     * @param int $id
     *
     * @return BlockReady
     * @throws NotFoundHttpException
     */
    protected function findModel2(int $id) : BlockReady
    {
        if (($model = BlockReady::findOne(['id' => $id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     *
     * @return ContentBlock
     * @throws NotFoundHttpException
     */
    protected function findContentBlockModel(int $id) : ContentBlock
    {
        if (($model = ContentBlock::findOne(['id' => $id, 'type' => ContentBlock::TYPE_BLOCK,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     *
     * @return ContentBlockField
     */
    protected function findContentBlockFieldModel(int $id) : ?ContentBlockField
    {
        return ContentBlockField::findOne(['content_block_id' => $id, 'deleted_at' => null,]);
    }

    /**
     * @param int $id
     *
     * @return Block
     * @throws NotFoundHttpException
     */
    protected function findBlockModel(int $id) : Block
    {
        if (($model = Block::findOne(['id' => $id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
