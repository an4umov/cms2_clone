<?php

namespace backend\modules\content\controllers;

use Yii;
use yii\web\{Controller, NotFoundHttpException};
use yii\filters\VerbFilter;
use common\models\{Content, ContentFilterPage};
use common\models\search\ContentSearch;
use common\components\helpers\{AppHelper, BlockHelper};

/**
 * Content2Controller implements the CRUD actions for Content model.
 */
class ContentController extends Controller
{
    const TYPE = Content::TYPE_PAGE;

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

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContentSearch();
        $searchModel->type = static::TYPE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = "
            select * from (
                select
                    landing_page_id
                from
                    department
                union all	
                select
                    landing_page_id
                from
                    department_menu	
                union all	
                select
                    landing_page_id
                from
                    department_menu_tag
                union all	
                select
                    landing_page_id
                from
                    green_menu
            ) as ids 
            where ids.landing_page_id IS NOT NULL
        ";
        $cmd = Yii::$app->db->createCommand($query);

        $ids = [];
        foreach($cmd->queryColumn() as $id) {
            $ids[$id] = $id;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ids' => $ids,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = new Content();
        $model->type = static::TYPE;
        if ($model->type === Content::TYPE_PAGE) {
            $model->page_index_type = Content::PAGE_INDEX_TYPE_DEFAULT;
        }

        $post = [];
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
        }

        $isExpand = false;
        if ($model->load($post) && $model->save()) {
            if (isset($post[AppHelper::BTN_SAVE_CLOSE])) {
                return $this->redirect('index');
            } elseif (isset($post[AppHelper::BTN_SAVE_STAY])) {
                $isExpand = true;
            }

            return $this->redirect(['update', 'id' => $model->id, 'e' => $isExpand,]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, static::TYPE);

        $post = [];
        $expanded = [];
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (!empty($post['expanded']) && is_array($post['expanded'])) {
                foreach ($post['expanded'] as $contentBlockID => $value) {
                    if (!empty($value)) {
                        $expanded[$contentBlockID] = $contentBlockID;
                    }
                }
            }
        }

        if ($model->load($post) && $model->save()) {
            if (isset($post[AppHelper::BTN_SAVE_CLOSE])) {
                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'contentFilters' => $model->getContentFilters()->all(),
            'contentFilterPages' => $model->getContentFilterPages()->all(),
            'allContentFilterPages' => ContentFilterPage::find()->select(['content_id', 'type', 'department_content_id',])->asArray()->all(),
            'contentTags' => $model->getContentCustomTags()->all(),
            'filters' => BlockHelper::getContentFilterList(),
            'tags' => BlockHelper::getContentTagList(),
            'expanded' => $expanded,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDelete($id)
    {
        $this->findModel($id, static::TYPE)->delete();

        return $this->redirect(['index',]);
    }

    /**
     * @param int    $id
     * @param string $type
     *
     * @return Content|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id, string $type)
    {
        if (($model = Content::findOne(['id' => $id, 'type' => $type, 'deleted_at' => null,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
