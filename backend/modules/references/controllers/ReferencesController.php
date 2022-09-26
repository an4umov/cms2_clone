<?php

namespace backend\modules\references\controllers;

use common\components\helpers\AppHelper;
use common\models\ReferenceBuyer;
use common\models\ReferenceDelivery;
use common\models\ReferenceDeliveryGroup;
use common\models\ReferencePartner;
use common\models\ReferencePayment;
use common\models\ReferencePaymentGroup;
use common\models\References;
use common\models\search\ReferenceBuyerSearch;
use common\models\search\ReferenceDeliveryGroupSearch;
use common\models\search\ReferenceDeliverySearch;
use common\models\search\ReferencePartnerSearch;
use common\models\search\ReferencePaymentGroupSearch;
use common\models\search\ReferencePaymentSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * Class ReferencesController
 *
 * @package backend\modules\references\controllers
 */
class ReferencesController extends Controller
{
    private $_class;

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class): void
    {
        $this->_class = $class;
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
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $dataProvider = null;
        switch ($this->getClass()) {
            case ReferencePartner::class:
                $searchModel = new ReferencePartnerSearch();
                break;
            case ReferenceBuyer::class:
                $searchModel = new ReferenceBuyerSearch();
                break;
            case ReferenceDelivery::class:
                $searchModel = new ReferenceDeliverySearch();
                break;
            case ReferenceDeliveryGroup::class:
                $searchModel = new ReferenceDeliveryGroupSearch();
                break;
            case ReferencePayment::class:
                $searchModel = new ReferencePaymentSearch();
                break;
            case ReferencePaymentGroup::class:
                $searchModel = new ReferencePaymentGroupSearch();
                break;
        }

        if ($searchModel) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $class = $this->getClass();
        /** @var References $model */
        $model = new $class;
        $model->is_active = true;

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
        $model = $this->findModel($id);

        $post = [];
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
        }

        if ($model->load($post) && $model->save()) {
            if (isset($post[AppHelper::BTN_SAVE_CLOSE])) {
                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index',]);
    }

    /**
     * @param int    $id
     *
     * @return References
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id)
    {
        $class = $this->getClass();
        if (($model = $class::findOne(['id' => $id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
