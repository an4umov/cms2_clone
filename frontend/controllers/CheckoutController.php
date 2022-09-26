<?php

namespace frontend\controllers;

use common\components\helpers\CatalogHelper;
use common\models\Articles;
use common\models\Catalog;
use common\models\FullPrice;
use common\models\Order;
use frontend\components\widgets\CatalogListWidget;
use \Yii;
use frontend\models\search\CatalogTreeSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use YandexCheckout\Model\NotificationEventType;

class CheckoutController extends Controller
{
    /**
     * @var \devanych\cart\Cart $cart
     */
    private $_cart;

    /**
     * @return \devanych\cart\Cart
     */
    public function getCart(): \devanych\cart\Cart
    {
        return $this->_cart;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'order-pay' => ['GET',],
                    'order-received' => ['POST', 'GET',],
                    'order-received-test' => ['POST', 'GET',],
                    'order-canceled' => ['POST', 'GET',],
                    'refund-succeeded' => ['POST', 'GET',],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->_cart = Yii::$app->cart;
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrderPay(int $id)
    {
        $model = $this->_findOrder($id);

        return $this->render('pay', [
            'cart' => $this->getCart(),
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrderReceived(int $id)
    {
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request->getPort();
        } else {
            $request = Yii::$app->request->get();
        }

        file_put_contents('./test_shop_request.log', date('d-m-Y H:i:s').PHP_EOL, FILE_APPEND);
        file_put_contents('./test_shop_request.log', print_r($request, true).PHP_EOL.'****************'.PHP_EOL, FILE_APPEND);

        $model = $this->_findOrder($id);
        if ($model->status !== Order::STATUS_SUCCEEDED) {
            $model->status = Order::STATUS_SUCCEEDED;
            if ($model->save()) {
                $this->getCart()->clear();
            }
        }

        return $this->render('received', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrderCanceled(int $id)
    {
        $model = $this->_findOrder($id);
        $model->status = Order::STATUS_CANCELED;
        $model->save();

        return $this->render('canceled', [
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRefundSucceeded(int $id)
    {
        $model = $this->_findOrder($id);
        $model->status = Order::STATUS_CANCELED;
        $model->logMessage = 'Возврат средств произведен для заказа '.$id;
        $model->save();

        return $this->render('refund_succeeded', [
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * @return string
     */
    public function actionOrderReceivedNotification()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);
        } catch (Exception $e) {
            file_put_contents('./test_shop_request_error.log', $e->getMessage().PHP_EOL.'#####################'.PHP_EOL, FILE_APPEND);
        }

        $payment = $notification->getObject();
        file_put_contents('./test_shop_request_notification.log', var_export($payment, true).PHP_EOL.'****************'.PHP_EOL, FILE_APPEND);

        return $this->render('received', [
            'cart' => $this->getCart(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Order
     * @throws NotFoundHttpException
     */
    private function _findOrder(int $id) : Order
    {
        $model = Order::findOne(['id' => $id,]);

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден');
    }
}