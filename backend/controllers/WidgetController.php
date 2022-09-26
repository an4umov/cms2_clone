<?php

namespace backend\controllers;

use common\models\ContentItem;
use common\models\Tile;
use Yii;
use common\models\Widget;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WidgetController implements the CRUD actions for Widget model.
 */
class WidgetController extends Controller
{
    const ERROR_UNDEFINED_TYPE = 'Undefined widget type or type is null';

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
     * @param null $type
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionIndex($type = null)
    {
        if (is_null($type)) {
            throw new BadRequestHttpException(self::ERROR_UNDEFINED_TYPE);
        }

        $query =  Widget::find()->where(['type' => $type]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);
    }

    /**
     * @param null $type
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionCreate($type = null)
    {
        if (is_null($type)) {
            throw new BadRequestHttpException(self::ERROR_UNDEFINED_TYPE);
        }
        $model = new Widget();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->_assignItems($model);
            return $this->redirect(['index', 'type' => $type]);
        }

        return $this->render('create', [
            'model' => $model,
            'type' => $type
        ]);
    }

    /**
     * @param $id
     * @param $type
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $type)
    {
        if (is_null($type)) {
            throw new BadRequestHttpException(self::ERROR_UNDEFINED_TYPE);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->_assignItems($model);
            return $this->redirect(['index', 'type' => $type]);
        }

        return $this->render('update', [
            'model' => $model,
            'type' => $type
        ]);
    }

    /**
     * @param $id
     * @param $type
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $type)
    {
        if (is_null($type)) {
            throw new BadRequestHttpException(self::ERROR_UNDEFINED_TYPE);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'type' => $type]);
    }

    /**
     * Finds the Widget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Widget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Widget::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function _assignItems(Widget $model)
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
