<?php

namespace backend\controllers;

use common\models\Composite;
use common\models\ContentItem;
use services\gallery\GalleryInterface;
use Yii;
use common\models\Gallery;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
    private $galleryService;
    private $filesPath;

    public function __construct(string $id, Module $module, GalleryInterface $galleryService, array $config = [])
    {
        $this->galleryService = $galleryService;
        $this->filesPath =  Yii::getAlias("@files") . DIRECTORY_SEPARATOR;
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
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Gallery::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $gallery = new Gallery();

        if ($gallery->load(Yii::$app->request->post()) && $gallery->save()) {
            $images = UploadedFile::getInstances($gallery, 'images_list');
            if ($images) {
                $this->galleryService->addImages($gallery, $images);
            }
            $this->_assignItems($gallery);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $gallery,
        ]);
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        /** @var Gallery $gallery */
        $gallery = $this->findModel($id);

        if ($gallery->load(Yii::$app->request->post()) && $gallery->save()) {
            $images = UploadedFile::getInstances($gallery, 'images_list');
            if ($images) {
                $this->galleryService->addImages($gallery, $images);
            }
            $this->_assignItems($gallery);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $gallery,
            'filesPath' => $this->filesPath
        ]);
    }

    /**
     * Deletes an existing Gallery model.
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
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function _assignItems(Gallery $model)
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
