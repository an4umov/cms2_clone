<?php

namespace backend\controllers;

use common\models\File;
use services\ContentItemService;
use services\FileService;
use Yii;
use common\models\ContentItem;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\base\Module;


/**
 * ContentItemController implements the CRUD actions for ContentItem model.
 */
class ContentItemController extends Controller
{

    private $contentItemService;

    public function __construct(string $id, Module $module, ContentItemService $contentItemService, array $config = [])
    {
        $this->contentItemService = $contentItemService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ContentItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ContentItem::find(),
            'sort' => ['defaultOrder'=>'type ASC']
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContentItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ContentItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ContentItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveTypeToSession($model->type);

            $isAttached = $this->attachImage($model);

            if (! $isAttached) {
                return $this->redirect(['update', 'id' => $model->id]);
            }

            return $this->redirect(['index']);
        }

        $lastSelectedType = $this->getTypeFromSession();

        return $this->render('create', [
            'model' => $model,
            'type' => $lastSelectedType
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveTypeToSession($model->type);
            $isAttached = $this->attachImage($model);

            if (! $isAttached) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'type' => $model->type
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ContentItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function attachImage(ContentItem $item)
    {
        $isAttached = $this->contentItemService->attachImage($item);

        if (! $isAttached) {
            if ( $this->contentItemService->issetError(ContentItem::ERROR_INVALID_RATIO) ) {
                $message = ContentItem::ERROR_INVALID_RATIO_MESSAGE . ". Соотношение может быть в пределах " . ContentItem::getRatio($item->type) . " +/- " . ContentItem::RATIO_ACCURACY;
                Yii::$app->session->setFlash(ContentItem::ERROR_INVALID_RATIO, $message);
            }
        }

        return $isAttached;
    }


    public function actionDeleteImage($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        $contentItem = ContentItem::findOne($id);
        if (is_null($contentItem)) {
            return false;
        }

        $delete = $contentItem->unlinkAll('attachedImage', true);

        return $this->asJson([
            'result' => $delete
        ]);
    }

    private function saveTypeToSession($typeId)
    {
        if (! is_null($typeId)) {
            Yii::$app->session->set(ContentItem::SESSION_KEY_TYPE, (int)$typeId);
        }
    }

    private function getTypeFromSession()
    {
        return Yii::$app->session->get(ContentItem::SESSION_KEY_TYPE);
    }

}
