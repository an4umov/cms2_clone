<?php

namespace backend\controllers;

use common\models\ContentItem;
use services\banners\CompositeService;
use Yii;
use common\models\Composite;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\base\Module;

/**
 * CompositeController implements the CRUD actions for Composite model.
 */
class CompositeController extends Controller
{
    protected $compositeService;

    public function __construct(string $id, Module $module, CompositeService $compositeService, array $config = [])
    {
        $this->compositeService = $compositeService;
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
     * Lists all Composite models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Composite::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Composite model.
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
     * Creates a new Composite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Composite();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->_assignItems($model);

            $images = UploadedFile::getInstances($model, 'images_list');
            if ($images) {
                $this->compositeService->addImages($model, $images);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Composite model.
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

            $images = UploadedFile::getInstances($model, 'images_list');
            if ($images) {
                $this->compositeService->addImages($model, $images);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Composite model.
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
     * Finds the Composite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Composite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Composite::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function _assignItems(Composite $model)
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
