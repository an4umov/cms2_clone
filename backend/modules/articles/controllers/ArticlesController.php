<?php

namespace backend\modules\articles\controllers;

use backend\models\old\Tags;
use Yii;
use backend\models\old\Articles;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
{
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
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
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
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->upload($model);
            $this->_assignTags($model);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Articles model.
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
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    private function upload(Articles $model)
    {
        $model->image = UploadedFile::getInstance($model, 'image');

        $path = 'uploads' .  DIRECTORY_SEPARATOR . 'images';
        if ($model->image && $model->validate()) {
            if (! is_writable(Yii::getAlias('@' . $path))) {
                @chmod(Yii::getAlias('@' . $path), 775);
            }
            $image = md5($model->image->baseName) . '.' . $model->image->extension;
            $realPath = Yii::getAlias('@' . $path);
            if (! is_writable($realPath)) {
                @chmod($realPath, 775);
            }
            $model->image->saveAs($realPath . DIRECTORY_SEPARATOR . $image);
            $model->announce_image = DIRECTORY_SEPARATOR . $path .  DIRECTORY_SEPARATOR . md5($model->image->baseName) . '.' . $model->image->extension;
            $model->save();
        }
    }

    private function _assignTags(Articles $model)
    {
        $tags = Tags::find()->all();
        $_tags = [];

        foreach ($tags as $tag) {
            $_tags[$tag->name] = $tag;
        }
        if (!empty($model->articleTags)) {
            $allTags = \yii\helpers\ArrayHelper::map($tags, 'name', 'name');

            foreach ($model->articleTags as $tag) {
                if (! in_array($tag, $allTags)) {
                    $linkTag = new Tags();
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
     * Deletes an existing Articles model.
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
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
