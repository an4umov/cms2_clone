<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CartHelper;
use common\models\CartSettings;
use common\models\Order;
use common\models\OrderItem;
use common\models\Settings;
use common\models\ShopOrder;
use common\models\ShopOrderItem;
use \Yii;
use common\components\helpers\CatalogHelper;
use common\models\PriceList;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{
    public $enableCsrfValidation = false;

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
                    'index' => ['GET',],
                    'add' => ['POST',], //plus
                    'change' => ['POST',],
                    'remove' => ['POST', 'GET',],
                    'reduce' => ['POST',], //minus
                    'clear' => ['POST', 'GET',],
                    'checkout' => ['POST', 'GET',],
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
     * корзина
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $this->layout = 'cart';

        return $this->render('index', [
            'cart' => $this->getCart(),
            'activeAction' => CartHelper::ACTIVE_ACTION_INDEX,
            'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_CART),
            'shopOrder' => $this->_getShopOrder(),
        ]);
    }

    /**
     * покупатель
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCustomer()
    {
        $this->layout = 'cart';
        $shopOrder = $this->_getShopOrder();
        $cart = $this->getCart();

        if ($shopOrder->isNewRecord) {
            if (!Yii::$app->user->isGuest) {
                $shopOrder->name = Yii::$app->user->getDisplayName();
                $shopOrder->email = Yii::$app->user->getEmail();
                $shopOrder->phone = Yii::$app->user->getPhone();;
            } else {
                $shopOrder->name = $shopOrder->email = $shopOrder->phone = '';
            }
        }

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $this->_setConfirmationData($shopOrder, $cart);
            if (!Yii::$app->user->isGuest) {
                $shopOrder->user_id = Yii::$app->user->id;
            }

            if ($shopOrder->load($post) && $shopOrder->save()) {
                AppHelper::setCookieValue(CartHelper::COOKIE_CART_ORDER_ID, $shopOrder->id);
            } else {
                $errors = $shopOrder->getFirstErrors();
                \Yii::$app->session->addFlash('errors', $errors);
            }
        }
        return $this->render('customer', [
            'cart' => $this->getCart(),
            //'errors' => \Yii::$app->session->getFlash('errors'),
            'activeAction' => CartHelper::ACTIVE_ACTION_CUSTOMER,
            'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_CUSTOMER),
            'shopOrder' => $shopOrder,
        ]);
    }

    /**
     * получение
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionDelivery()
    {
        $this->layout = 'cart';
        $shopOrder = $this->_getShopOrder();
        $cart = $this->getCart();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $this->_setConfirmationData($shopOrder, $cart);
            if ($shopOrder->load($post) && $shopOrder->save()) {
                AppHelper::setCookieValue(CartHelper::COOKIE_CART_ORDER_ID, $shopOrder->id);
            } else {
                $errors = $shopOrder->getFirstErrors();
                \Yii::$app->session->addFlash('errors', $errors);
            }
        }
        return $this->render('delivery', [
            'cart' => $this->getCart(),
            'activeAction' => CartHelper::ACTIVE_ACTION_DELIVERY,
            'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_DELIVERY),
            'shopOrder' => $shopOrder,
        ]);
    }

    /**
     * оплата
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionPayment()
    {
        $this->layout = 'cart';
        $shopOrder = $this->_getShopOrder();
        $cart = $this->getCart();
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $this->_setConfirmationData($shopOrder, $cart);
            if ($shopOrder->load($post) && $shopOrder->save()) {
                AppHelper::setCookieValue(CartHelper::COOKIE_CART_ORDER_ID, $shopOrder->id);
            } else {
                $errors = $shopOrder->getFirstErrors();
                \Yii::$app->session->addFlash('errors', $errors);
            }
        }

        return $this->render('payment', [
            'cart' => $this->getCart(),
            'activeAction' => CartHelper::ACTIVE_ACTION_PAYMENT,
            'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_PAYMENT),
            'shopOrder' => $shopOrder,
        ]);
    }

    /**
     * отправить
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionConfirmation()
    {
        $this->layout = 'cart';
        $shopOrder = $this->_getShopOrder();
        $cart = $this->getCart();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!empty($post['confirmation'])) {
                if ($shopOrder->load($post)) {
                    $this->_setConfirmationData($shopOrder, $cart);

                    if ($shopOrder->save()) {
                        AppHelper::setCookieValue(CartHelper::COOKIE_CART_ORDER_ID, $shopOrder->id);
                    } else {
                        throw new BadRequestHttpException('Ошибка сохранения: '.print_r($shopOrder->getFirstErrors(), true));
                    }
                }

                $cartItems = $this->getCart()->getItems();
                /** @var $item \devanych\cart\CartItem */
                foreach($cartItems as $item) {
                    /** @var PriceList $product */
                    $product = $item->getProduct();

                    $orderItem = new ShopOrderItem();
                    $orderItem->order_id = $shopOrder->id;
                    $orderItem->article_id = $product->article->id;
                    $orderItem->code = $product->code;
                    $orderItem->article_number = $product->article_number;
                    $orderItem->product_code = $product->product_code;
                    $orderItem->manufacturer = $product->manufacturer;
                    $orderItem->price = $item->getPrice();
                    $orderItem->key = $product->key;
                    $orderItem->quantity = $item->getQuantity();
                    $orderItem->name = $product->article->name;
                    $orderItem->title = $product->article->title;

                    if (!$orderItem->save()) {
                        throw new BadRequestHttpException('Товар в заказе #'.$shopOrder->id.' не сохранен: '.print_r($orderItem->getFirstErrors(), true));
                    }
                }
                $items = $shopOrder->getShopOrderItems()->asArray(true)->all();
                // return $this->render('/mail/shoporder', [
                //     'order' => $shopOrder,
                //     //'items' => $cartItems
                // ]);

                $globalSettingsData = AppHelper::getCartSettings()->getData();

                if ($shopOrder->sendOrder()) {
                    AppHelper::deleteCookie(CartHelper::COOKIE_CART_ORDER_ID);
                    $cart->clear();
                    $message = $globalSettingsData[Settings::CART_SUCCESS_MESSAGE_KEY];
                } else {
                    $message = $globalSettingsData[Settings::CART_FAILURE_MESSAGE_KEY];
                }

                return $this->render('confirmation_message', [
                    'activeAction' => CartHelper::ACTIVE_ACTION_CONFIRMATION,
                    'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_CONFIRMATION),
                    'message' => $message,
                ]);
            } else {
                if ($shopOrder->load($post)) {
                    $this->_setConfirmationData($shopOrder, $cart);
                    if ($shopOrder->save()) {
                        AppHelper::setCookieValue(CartHelper::COOKIE_CART_ORDER_ID, $shopOrder->id);
                    } else {
                        $errors = $shopOrder->getFirstErrors();
                        \Yii::$app->session->addFlash('errors', $errors);
                    }
                }
            }
        }

        return $this->render('confirmation', [
            'cart' => $cart,
            'activeAction' => CartHelper::ACTIVE_ACTION_CONFIRMATION,
            'cartSettings' => $this->_getCartSettings(CartSettings::TYPE_CONFIRMATION),
            'shopOrder' => $shopOrder,
        ]);
    }

    /**
     * @return string
     */
    private function _setConfirmationData($shopOrder, $cart)
    {
        $shopOrder->total = $cart->getTotalCost();
        $shopOrder->total_cost = $shopOrder->total - $shopOrder->calcOrderDiscounts();
        
        if ($shopOrder->delivery_type_id) {
            $shopOrder->delivery_type_name = CartSettings::getSettingNameByID($shopOrder->delivery_type_id);
        }
        if ($shopOrder->delivery_carrier_id) {
            $shopOrder->delivery_carrier_name = CartSettings::getSettingNameByID($shopOrder->delivery_carrier_id);
        }
        if ($shopOrder->settings_payment_type_id) {
            $shopOrder->payment_type_name = CartSettings::getSettingNameByID($shopOrder->settings_payment_type_id);
        }
        if ($shopOrder->settings_payment_id) {
            $shopOrder->payment_name = CartSettings::getSettingNameByID($shopOrder->settings_payment_id);
        }
    }

    /**
     * @return string
     */
    public function actionCheckout()
    {
        $cart = $this->getCart();

        $model = new Order();
        $model->user_id = Yii::$app->user->id;
        $model->comment = 'Тестовый заказ в '.date('d-m-Y H:i:s');
        $model->status = Order::STATUS_PENDING;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if ($model->load($post) && $model->save()) {
                $cartItems = $cart->getItems();

                foreach($cartItems as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $model->id;
                    $orderItem->article_number = $item->getProduct()->article_number;
                    $orderItem->price = (float)$item->getPrice();
                    $orderItem->quantity = $item->getQuantity();
                    $orderItem->key = $item->getProduct()->key;
                    $orderItem->save();
                }

                if (isset($post[AppHelper::BTN_CANCEL])) {
                    $model->status = Order::STATUS_CANCELED;
                    $model->logMessage = 'Отмена заказа пользователем';
                    $model->save();

                    return $this->redirect('/cart');
                }

                return $this->redirect('/checkout/order-pay/'.$model->id);
            }
        }

        return $this->render('checkout', [
            'cart' => $cart,
            'model' => $model,
        ]);
    }

    /**
     * @return array
     */
    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];

        $key = Yii::$app->request->post('id');
        $qty = Yii::$app->request->post('qty', 1);

        try {
            $product = $this->_getProduct($key);
            $quantity = $this->_getQuantity($qty, $product->availability);

            if ($item = $this->getCart()->getItem($product->{PriceList::PRODUCT_KEY})) {
                $this->getCart()->plus($item->getId(), $quantity);
            } else {
                $this->getCart()->add($product, $quantity);
            }

            $response['ok'] = true;
            $response['count'] = $this->getCart()->getTotalCount();
            $response['total'] = $this->getCart()->getTotalCost();
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            $response['message'] = $e->getMessage();
        }

            return $response;
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionReduce()
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Неверный тип запроса');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];

        $key = Yii::$app->request->post('id');

        if (empty($key)) {
            $response['message'] = 'Не указан обязательный параметр';
        } else {
            try {
                $product = $this->_getProduct($key);

                if ($item = $this->getCart()->getItem($product->{PriceList::PRODUCT_KEY})) {
                    $quantity = $item->getQuantity();
                    if ($quantity > 1) {
                        $this->getCart()->change($item->getId(), --$quantity);
                        $response['ok'] = true;
                    } elseif ($quantity === 1) {
                        $this->getCart()->remove($product->{PriceList::PRODUCT_KEY});
                        $response['ok'] = true;
                    } else {
                        $response['message'] = 'Неверное кол-во товара в корзине: '.$quantity;
                    }

                    $response['count'] = $this->getCart()->getTotalCount();
                    $response['total'] = $this->getCart()->getTotalCost();
                } else {
                    $response['message'] = 'Не найден товар в корзине';
                }
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                $response['message'] = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionChange()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];

        $key = Yii::$app->request->post('id');
        $qty = (int) Yii::$app->request->post('qty', 1);

        if ($key && $qty) {
            try {
                $product = $this->_getProduct($key);
                $quantity = $this->_getQuantity($qty, $product->availability);
                if ($item = $this->getCart()->getItem($product->{PriceList::PRODUCT_KEY})) {
                    $this->getCart()->change($item->getId(), $quantity);
                    $response['ok'] = true;
                    $response['count'] = $this->getCart()->getTotalCount();
                    $response['total'] = $this->getCart()->getTotalCost();
                }
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                $response['message'] = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @return array|Response
     * @throws BadRequestHttpException
     */
    public function actionRemove()
    {
        $response = ['ok' => false, 'count' => 0,];
        if (Yii::$app->request->isAjax) {
            $key = Yii::$app->request->post('id');
            Yii::$app->response->format = Response::FORMAT_JSON;
        } else {
            $key = Yii::$app->request->get('id', 0);
        }

        if (empty($key)) {
            if (Yii::$app->request->isAjax) {
                $response['message'] = 'Не указан обязательный параметр';
            } else {
                throw new BadRequestHttpException('Не указан обязательный параметр');
            }
        } else {
            try {
                $product = $this->_getProduct($key);
                $this->getCart()->remove($product->{PriceList::PRODUCT_KEY});

                if (Yii::$app->request->isAjax) {
                    $response['ok'] = true;
                    $response['count'] = $this->getCart()->getTotalCount();
                    $response['total'] = $this->getCart()->getTotalCost();
                }
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                if (Yii::$app->request->isAjax) {
                    $response['message'] = $e->getMessage();
                } else {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return Yii::$app->request->isAjax ? $response : $this->redirect(['index']);
    }

    /**
     * @return array|Response
     */
    public function actionClear()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        $this->getCart()->clear();

        return Yii::$app->request->isAjax ? ['ok' => true,] : $this->redirect(['index']);
    }

    /**
     * @param $key
     *
     * @return PriceList
     * @throws NotFoundHttpException
     */
    private function _getProduct($key) : PriceList
    {
        if (($product = CatalogHelper::getPriceListModelByKey($key)) !== null) {
            return $product;
        }

        throw new NotFoundHttpException('Товар не найден');
    }

    /**
     * @return ShopOrder
     */
    private function _getShopOrder() : ShopOrder
    {
        $shopOrder = new ShopOrder();
        $shopOrderID = AppHelper::getCookieValue(CartHelper::COOKIE_CART_ORDER_ID);
        if (!empty($shopOrderID)) {
            $where = ['id' => $shopOrderID,];
            if (!Yii::$app->user->isGuest) {
                $where['user_id'] = Yii::$app->user->id;
            }
            $model = ShopOrder::find()->where($where)->with('shopOrderItems')->one();

            if ($model) {
                $shopOrder = $model;
            }
        }

        return $shopOrder;
    }

    /**
     * @param string $type
     *
     * @return array
     * @throws BadRequestHttpException
     */
    private function _getCartSettings(string $type) : array
    {
        $cartSettings = CartHelper::getCartSettingTypeData($type);
        if ($cartSettings) {
            return $cartSettings;
        }

        throw new BadRequestHttpException('Не заданы настройки для корзины');
    }

    /**
     * @param integer $qty
     * @param integer $maxQty
     *
     * @return integer
     * @throws \DomainException if the product cannot be found
     */
    private function _getQuantity($qty, $maxQty) : int
    {
        return $qty;

        $quantity = $qty > 0 ? (int)$qty : 1;
        if ($quantity > $maxQty) {
            throw new \DomainException('Товара в наличии всего ' . Html::encode($maxQty) . ' шт.');
        }

        return $quantity;
    }
}