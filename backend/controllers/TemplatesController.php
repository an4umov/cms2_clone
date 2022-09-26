<?php

namespace backend\controllers;

use Yii;
use backend\models\Template;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplatesController implements the CRUD actions for Template model.
 */
class TemplatesController extends Controller
{
    /**
     * @var array
     */
    protected $staticTemplates = [];

    /**
     * @return array
     */
    public function getStaticTemplates()
    {
        return $this->staticTemplates;
    }

    public function init()
    {
        parent::init();
        $staticTemplatesFormsPath = Yii::getAlias('@backend/views/templates/templates_forms/');
        $files = scandir($staticTemplatesFormsPath);
        foreach ( $files as $file ) {
            if ($file === '.' || $file === '..')
                continue;
            $fileName = pathinfo($staticTemplatesFormsPath . $file, PATHINFO_FILENAME);
            try {
                $template = $this->renderPartial("templates_forms/" . $fileName);
            } catch(Exception $exception) {
                $template = "";
            }
            $this->staticTemplates[$fileName] = $template;
        }
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Template::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
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
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->type === Template::TYPE_MATERIAL_PREVIEW) {
                $model->content = $this->renderPartial('templates_forms/material_preview');
                $model->name = Template::getTypeName(Template::TYPE_MATERIAL_PREVIEW);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'staticTemplates' => $this->staticTemplates
        ]);
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'staticTemplates' => $this->staticTemplates
        ]);
    }

    /**
     * Deletes an existing Template model.
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
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
