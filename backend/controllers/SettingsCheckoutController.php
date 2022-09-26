<?php

namespace backend\controllers;

use common\models\ReferenceDelivery;
use common\models\ReferenceDeliveryGroup;
use common\models\ReferencePayment;
use common\models\ReferencePaymentGroup;
use common\models\search\SettingsCheckoutBuyerSearch;
use common\models\SettingsCheckoutBuyer;
use Yii;
use common\models\SettingsCheckout;
use common\models\search\SettingsCheckoutSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \common\components\helpers\ReferenceHelper;

/**
 * SettingsCheckoutController implements the CRUD actions for SettingsCheckout model.
 */
class SettingsCheckoutController extends Controller
{
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
                    'delete-buyer' => ['POST'],
                    'delete-delivery-group' => ['POST'],
                    'delete-delivery' => ['POST'],
                    'delete-payment-group' => ['POST'],
                    'delete-payment' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SettingsCheckout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingsCheckoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SettingsCheckout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SettingsCheckout();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateBuyer(int $id)
    {
        $model = new SettingsCheckoutBuyer();
        $model->is_active = true;
        $settingsCheckoutModel = $this->findModel($id);
        $model->settings_checkout_id = $settingsCheckoutModel->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->settings_checkout_id,]);
        }

        return $this->render('create_buyer', [
            'model' => $model,
            'settingsCheckoutModel' => $settingsCheckoutModel,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionCreateDeliveryGroup(int $id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (Yii::$app->request->isPost) {
            $dgid = Yii::$app->request->post('dgid', 0);

            if (!empty($dgid)) {
                $model = ReferenceHelper::addDeliveryGroup($model, $dgid);

                if ($model->save()) {
                    return $this->redirect(['update-buyer', 'id' => $id,]);
                }
            }
        }

        return $this->render('create_delivery_group', [
            'model' => $model,
            'deliveryGroupModel' => null,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionCreateDelivery(int $id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);
        $dgid = Yii::$app->request->get('dgid', 0);

        if (Yii::$app->request->isPost) {
            $dgid = Yii::$app->request->post('dgid', 0);
            $did = Yii::$app->request->post('did', 0);

            if (!empty($dgid) && !empty($did)) {
                $model = ReferenceHelper::addDelivery($model, $dgid, $did);

                if ($model->save()) {
                    return $this->redirect(['update-delivery-group', 'id' => $id, 'dgid' => $dgid,]);
                }
            }
        }

        return $this->render('create_delivery', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
        ]);
    }

    public function actionCreatePaymentGroup(int $id)
    {
        $dgid = Yii::$app->request->get('dgid', 0);
        $did = Yii::$app->request->get('did', 0);
        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);
            $deliveryID = Yii::$app->request->post('did', 0);
            $paymentGroupID = Yii::$app->request->post('pgid', 0);

            if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID)) {
                $model = ReferenceHelper::addPaymentGroup($model, $deliveryGroupID, $deliveryID, $paymentGroupID);

                if ($model->save()) {
                    return $this->redirect(['update-delivery', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID,]);
                }
            }
        }

        return $this->render('create_payment_group', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'deliveryModel' => ReferenceDelivery::findOne($did),
        ]);
    }

    public function actionCreatePayment(int $id)
    {
        $dgid = Yii::$app->request->get('dgid', 0);
        $did = Yii::$app->request->get('did', 0);
        $pgid = Yii::$app->request->get('pgid', 0);
        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);
            $deliveryID = Yii::$app->request->post('did', 0);
            $paymentGroupID = Yii::$app->request->post('pgid', 0);
            $paymentID = Yii::$app->request->post('pid', 0);

            if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID) && !empty($paymentID)) {
                $model = ReferenceHelper::addPayment($model, $deliveryGroupID, $deliveryID, $paymentGroupID, $paymentID);

                if ($model->save()) {
                    return $this->redirect(['update-payment-group', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID, 'pgid' => $paymentGroupID,]);
                }
            }
        }

        return $this->render('create_payment', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'deliveryModel' => ReferenceDelivery::findOne($did),
            'paymentGroupModel' => ReferencePaymentGroup::findOne($pgid),
        ]);
    }

    /**
     * Updates an existing SettingsCheckout model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        $searchModel = new SettingsCheckoutBuyerSearch();
        $searchModel->settings_checkout_id = $model->id;
        $dataProvider = $searchModel->search([]);

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateBuyer($id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        return $this->render('update_buyer', [
            'model' => $model,
            'dataProvider' => ReferenceHelper::getDeliveryGroupProvider($model),
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateDeliveryGroup($id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);
        $dgid = Yii::$app->request->get('dgid', 0);

        if (empty($dgid)) {
            throw new BadRequestHttpException('Не задан обязательный параметр');
        }

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);

            if (!empty($deliveryGroupID)) {
                $model = ReferenceHelper::setDeliveryGroup($model, $dgid, $deliveryGroupID);
                if ($model->save()) {
                    return $this->redirect(['update-buyer', 'id' => $id,]);
                }
            }
        }

        return $this->render('update_delivery_group', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'dataProvider' => ReferenceHelper::getDeliveryProvider($model, $dgid),
        ]);
    }

    public function actionUpdateDelivery($id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);
        $dgid = Yii::$app->request->get('dgid', 0);
        $did = Yii::$app->request->get('did', 0);

        if (empty($dgid) || empty($did)) {
            throw new BadRequestHttpException('Не задан обязательный параметр');
        }

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);
            $deliveryID = Yii::$app->request->post('did', 0);

            if (!empty($deliveryGroupID) && !empty($deliveryID)) {
                $model = ReferenceHelper::setDelivery($model, $dgid, $did, $deliveryID);
                if ($model->save()) {
                    return $this->redirect(['update-delivery-group', 'id' => $id, 'dgid' => $dgid,]);
                }
            }
        }

        return $this->render('update_delivery', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'deliveryModel' => ReferenceDelivery::findOne($did),
            'dataProvider' => ReferenceHelper::getPaymentGroupProvider($model, $dgid, $did),
        ]);
    }

    public function actionUpdatePaymentGroup($id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);
        $dgid = Yii::$app->request->get('dgid', 0);
        $did = Yii::$app->request->get('did', 0);
        $pgid = Yii::$app->request->get('pgid', 0);

        if (empty($dgid) || empty($did) || empty($pgid)) {
            throw new BadRequestHttpException('Не задан обязательный параметр');
        }

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);
            $deliveryID = Yii::$app->request->post('did', 0);
            $paymentGroupID = Yii::$app->request->post('pgid', 0);

            if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID)) {
                $model = ReferenceHelper::setPaymentGroup($model, $deliveryGroupID, $deliveryID, $pgid, $paymentGroupID);
                if ($model->save()) {
                    return $this->redirect(['update-delivery', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID,]);
                }
            }
        }

        return $this->render('update_payment_group', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'deliveryModel' => ReferenceDelivery::findOne($did),
            'paymentGroupModel' => ReferencePaymentGroup::findOne($pgid),
            'dataProvider' => ReferenceHelper::getPaymentProvider($model, $dgid, $did, $pgid),
        ]);
    }

    public function actionUpdatePayment($id)
    {
        $model = $this->findSettingsCheckoutBuyerModel($id);
        $dgid = Yii::$app->request->get('dgid', 0);
        $did = Yii::$app->request->get('did', 0);
        $pgid = Yii::$app->request->get('pgid', 0);
        $pid = Yii::$app->request->get('pid', 0);

        if (empty($dgid) || empty($did) || empty($pgid) || empty($pid)) {
            throw new BadRequestHttpException('Не задан обязательный параметр');
        }

        if (Yii::$app->request->isPost) {
            $deliveryGroupID = Yii::$app->request->post('dgid', 0);
            $deliveryID = Yii::$app->request->post('did', 0);
            $paymentGroupID = Yii::$app->request->post('pgid', 0);
            $paymentID = Yii::$app->request->post('pid', 0);

            if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID) && !empty($paymentID)) {
                $model = ReferenceHelper::setPayment($model, $deliveryGroupID, $deliveryID, $paymentGroupID, $pid, $paymentID);
                if ($model->save()) {
                    return $this->redirect(['update-payment-group', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID, 'pgid' => $paymentGroupID,]);
                }
            } else {
                throw new BadRequestHttpException('Не заданы обязательные параметры');
            }
        }

        return $this->render('update_payment', [
            'model' => $model,
            'deliveryGroupModel' => ReferenceDeliveryGroup::findOne($dgid),
            'deliveryModel' => ReferenceDelivery::findOne($did),
            'paymentGroupModel' => ReferencePaymentGroup::findOne($pgid),
            'paymentModel' => ReferencePayment::findOne($pid),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteBuyer($id)
    {
        $this->findSettingsCheckoutBuyerModel($id)->delete();

        return $this->redirect(['/settings-checkout']);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteDeliveryGroup()
    {
        $id = Yii::$app->request->get('id', 0);
        $deliveryGroupID = Yii::$app->request->get('dgid', 0);

        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (!empty($deliveryGroupID)) {
            ReferenceHelper::deleteDeliveryGroup($model, $deliveryGroupID);
        }

        return $this->redirect(['/settings-checkout/update-buyer', 'id' => $id,]);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteDelivery()
    {
        $id = Yii::$app->request->get('id', 0);
        $deliveryGroupID = Yii::$app->request->get('dgid', 0);
        $deliveryID = Yii::$app->request->get('did', 0);

        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (!empty($deliveryGroupID) && !empty($deliveryID)) {
            ReferenceHelper::deleteDelivery($model, $deliveryGroupID, $deliveryID);
        }

        return $this->redirect(['/settings-checkout/update-delivery-group', 'id' => $id, 'dgid' => $deliveryGroupID,]);
    }

    /**
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeletePaymentGroup()
    {
        $id = Yii::$app->request->get('id', 0);
        $deliveryGroupID = Yii::$app->request->get('dgid', 0);
        $deliveryID = Yii::$app->request->get('did', 0);
        $paymentGroupID = Yii::$app->request->get('pgid', 0);

        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID)) {
            ReferenceHelper::deletePaymentGroup($model, $deliveryGroupID, $deliveryID, $paymentGroupID);
        }

        return $this->redirect(['/settings-checkout/update-delivery', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID,]);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeletePayment()
    {
        $id = Yii::$app->request->get('id', 0);
        $deliveryGroupID = Yii::$app->request->get('dgid', 0);
        $deliveryID = Yii::$app->request->get('did', 0);
        $paymentGroupID = Yii::$app->request->get('pgid', 0);
        $paymentID = Yii::$app->request->get('pid', 0);

        $model = $this->findSettingsCheckoutBuyerModel($id);

        if (!empty($deliveryGroupID) && !empty($deliveryID) && !empty($paymentGroupID) && !empty($paymentID)) {
            ReferenceHelper::deletePayment($model, $deliveryGroupID, $deliveryID, $paymentGroupID, $paymentID);
        }

        return $this->redirect(['/settings-checkout/update-payment-group', 'id' => $id, 'dgid' => $deliveryGroupID, 'did' => $deliveryID, 'pgid' => $paymentGroupID,]);
    }

    public function actionTree(int $id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('tree', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the SettingsCheckout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingsCheckout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SettingsCheckout::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findSettingsCheckoutBuyerModel($id)
    {
        if (($model = SettingsCheckoutBuyer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
