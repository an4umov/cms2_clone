<?php

namespace backend\controllers;

use common\models\ContentItem;
use common\models\File;
use services\FileService;
use Yii;
use common\models\InfoBlock;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InfoBlockController implements the CRUD actions for InfoBlock model.
 */
class InfoBlockController extends Controller
{
    protected $fileService;

    public function __construct($id, $module, FileService $fileService, $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($id, $module, $config);
    }

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
     * @param InfoBlock $model
     * @param UploadedFile $image
     * @return bool
     */
    public function addBgImage($model, UploadedFile $image): bool
    {
        $image = $this->addImage($image);
        $imageModel = new File();
        $imageModel->name = basename($image);
        $imageModel->path = $image;
        $imageModel->title = basename($image);
        if ($imageModel->save()) {
            $model->link('background', $imageModel);
        }
        return true;
    }

    public function addImage(UploadedFile $uploadedFile)
    {
        return $this->fileService->uploadFile($uploadedFile);
    }

    /**
     * Lists all InfoBlock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InfoBlock::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InfoBlock model.
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
     * Creates a new InfoBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfoBlock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->_assignItems($model);
            $image = UploadedFile::getInstance($model, 'upload_image');
            if ($image) {
                $this->addBgImage($model, $image);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InfoBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->_assignItems($model);
            $image = UploadedFile::getInstance($model, 'upload_image');
            if ($image) {
                $this->addBgImage($model, $image);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InfoBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);

        $model->unlink('background', $model);

    }

    /**
     * Finds the InfoBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfoBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfoBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function _assignItems(InfoBlock $model)
    {
        $all = ContentItem::find()->select([ 'id', 'title' ])->all();
        $list = [];

        foreach ( $all as $i ) {
            $list[$i->id] = $i;
        }
        $model->unlinkAll('contentItems', true);
        if ( ! empty($model->items) ) {
            foreach ( $model->items as $item ) {
                $linkItem = $list[$item];
                $model->link('contentItems', $linkItem);
            }
        }
    }
}
