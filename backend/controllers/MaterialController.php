<?php

namespace backend\controllers;

use common\models\Menu;
use common\models\Tag;
use creocoder\nestedsets\NestedSetsBehavior;
use services\FileService;
use Yii;
use common\models\Material;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends Controller
{
    private $fileService;

    public function __construct(string $id, Module $module, FileService $fileService, array $config = [])
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Material::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Material models.
     * @return mixed
     */
    public function actionSystem()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Material::find()->where(['is_main' => 1]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Material model.
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
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parentId = null)
    {
        $model = new Material();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->upload($model);
            $this->_assignTags($model);

            if (! is_null($parentId)) {
                /** @var Menu $menuParent */
                $menuParent = Menu::find()->where(['id' => $parentId])->one();

                if (! is_null($menuParent)) {
                    $model->link('menus', $menuParent);
                    return $this->redirect(['/menu/index']);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Material model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->upload($model);
            $model->unlinkAll('tags', true);
            $this->_assignTags($model);

            $continue = Yii::$app->request->post('continue');
            if (!is_null($continue)) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            if ($model->is_main) {
                return $this->redirect('system');
            }

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    private function upload(Material $model)
    {
        $model->materialPreview = UploadedFile::getInstance($model, 'materialPreview');

        $path = 'uploads' .  DIRECTORY_SEPARATOR . 'images';
        if ($model->materialPreview && $model->validate()) {
            if (! is_writable(Yii::getAlias('@' . $path))) {
                @chmod(Yii::getAlias('@' . $path), 775);
            }
            $image = md5($model->materialPreview->baseName) . '.' . $model->materialPreview->extension;
            $realPath = Yii::getAlias('@' . $path);
            if (! is_writable($realPath)) {
                @chmod($realPath, 775);
            }
            $model->materialPreview->saveAs($realPath . DIRECTORY_SEPARATOR . $image);
            $model->preview = DIRECTORY_SEPARATOR . $path .  DIRECTORY_SEPARATOR . md5($model->materialPreview->baseName) . '.' . $model->materialPreview->extension;
            $model->save();
        }
    }

    private function _assignTags(Material $model)
    {
        $tags = \common\models\Tag::find()->all();
        $_tags = [];

        foreach ($tags as $tag) {
            $_tags[$tag->name] = $tag;
        }
        if (!empty($model->materialTags)) {
            $allTags = \yii\helpers\ArrayHelper::map($tags, 'name', 'name');

            foreach ($model->materialTags as $tag) {
                if (! in_array($tag, $allTags)) {
                    $linkTag = new Tag();
                    $linkTag->name = $tag;
                    $linkTag->save();
                } else {
                    $linkTag = $_tags[$tag];
                }
                $model->link('tags', $linkTag);
            }
        }
    }

    /**
     * Deletes an existing Material model.
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
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function actionTest()
    {
        /** @var Menu $menu */
        $mat = Material::findOne(['id' => 2]);
        $parentId = 15;
        ////VarDumper::dump($mat->frontUrl("dfgdfg"), 5, 1);exit;
    }

    public function actionImagesList()
    {
        return $this->asJson($this->fileService->imagesList());
    }
}
