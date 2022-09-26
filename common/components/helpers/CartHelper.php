<?php
namespace common\components\helpers;


use backend\components\helpers\MenuHelper;
use common\models\Articles;
use common\models\CartSettings;
use common\models\Catalog;
use common\models\FullPrice;
use Yii;
use yii\helpers\Html;use yii\helpers\Url;
use yii\web\JsExpression;

class CartHelper
{
    const YA_KASSA_SHOP_ID = 717853;
    const YA_KASSA_SECRET_KEY = 'live_UyQJZqhZ0pUqTBQRsT1bDN_n9huIWOk91Jh91amK27E';

    const YA_KASSA_TEST_SHOP_ID = 725237;
    const YA_KASSA_TEST_SECRET_KEY = 'test_ZbIRYREGQg1qsk_BzpvQc_50ICxYCAbMt9gAs3-Tu9U';


    const CHECKOUT_STEP1_TYPE_FL = 'fl';
    const CHECKOUT_STEP1_TYPE_IP = 'ip';
    const CHECKOUT_STEP1_TYPE_UL = 'ul';
    const CHECKOUT_STEP1_TYPES = [self::CHECKOUT_STEP1_TYPE_FL, self::CHECKOUT_STEP1_TYPE_IP, self::CHECKOUT_STEP1_TYPE_UL,];

    const CHECKOUT_STEP2_TYPE_SELF = 'self';
    const CHECKOUT_STEP2_TYPE_MOSCOW = 'moscow';
    const CHECKOUT_STEP2_TYPE_TK = 'tk';
    const CHECKOUT_STEP2_TYPES = [self::CHECKOUT_STEP2_TYPE_SELF, self::CHECKOUT_STEP2_TYPE_MOSCOW, self::CHECKOUT_STEP2_TYPE_TK,];

    const CHECKOUT_STEP3_TYPE_CASHCOURIER = 'cashCourier';
    const CHECKOUT_STEP3_TYPE_CASHOFFICE = 'cashOffice';
    const CHECKOUT_STEP3_TYPE_CASHLESSCARD = 'cashlessCard';
    const CHECKOUT_STEP3_TYPE_CASHLESSBANK = 'cashlessBank';
    const CHECKOUT_STEP3_TYPES = [self::CHECKOUT_STEP3_TYPE_CASHCOURIER, self::CHECKOUT_STEP3_TYPE_CASHOFFICE, self::CHECKOUT_STEP3_TYPE_CASHLESSCARD, self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,];

    const CHECKOUT_TYPES = [
        self::CHECKOUT_STEP1_TYPE_FL => [
            self::CHECKOUT_STEP2_TYPE_MOSCOW => [
                self::CHECKOUT_STEP3_TYPE_CASHCOURIER,
                self::CHECKOUT_STEP3_TYPE_CASHLESSCARD,
                self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,
            ],
            self::CHECKOUT_STEP2_TYPE_SELF => [
                self::CHECKOUT_STEP3_TYPE_CASHOFFICE,
                self::CHECKOUT_STEP3_TYPE_CASHLESSCARD,
                self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,
            ],
            self::CHECKOUT_STEP2_TYPE_TK => [
                self::CHECKOUT_STEP3_TYPE_CASHOFFICE,
                self::CHECKOUT_STEP3_TYPE_CASHLESSCARD,
                self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,
            ],
        ],
        self::CHECKOUT_STEP1_TYPE_IP => [
            self::CHECKOUT_STEP2_TYPE_MOSCOW => [
                self::CHECKOUT_STEP3_TYPE_CASHCOURIER,
                self::CHECKOUT_STEP3_TYPE_CASHLESSCARD,
                self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,
            ],
            self::CHECKOUT_STEP2_TYPE_SELF => [
                self::CHECKOUT_STEP3_TYPE_CASHOFFICE,
                self::CHECKOUT_STEP3_TYPE_CASHLESSCARD,
                self::CHECKOUT_STEP3_TYPE_CASHLESSBANK,
            ],
        ],
        self::CHECKOUT_STEP1_TYPE_UL => [],
    ];

    const ACTIVE_ACTION_INDEX = 'index';
    const ACTIVE_ACTION_CUSTOMER = 'customer';
    const ACTIVE_ACTION_DELIVERY = 'delivery';
    const ACTIVE_ACTION_PAYMENT = 'payment';
    const ACTIVE_ACTION_CONFIRMATION = 'confirmation';

    const CART_SETTINGS_GLOBAL_ID = 0;
    const COOKIE_CART_ORDER_ID = 'cart_order_id';

    /**
     * @return int
     */
    public static function getCartItemsCount() : int
    {
        /**
         * @var \devanych\cart\Cart $cart
         */
        $cart = Yii::$app->cart;

        return $cart->getTotalCount();
    }

    /**
     * @return array
     */
    public static function getCartItemIds() : array
    {
        /**
         * @var \devanych\cart\Cart $cart
         */
        $cart = Yii::$app->cart;

        return $cart->getItemIds();
    }

    /**
     * @return array
     */
    public static function getCartItems() : array
    {
        /**
         * @var \devanych\cart\Cart $cart
         */
        $cart = Yii::$app->cart;

        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = ['id' => $item->getId(), 'quantity' => $item->getQuantity(), 'product' => $item->getProduct()->attributes,];
        }

        return $items;
    }

    /**
     * @param string $fullPriceKey
     *
     * @return \devanych\cart\CartItem
     */
    public static function getProduct(string $fullPriceKey)
    {
        /**
         * @var \devanych\cart\Cart $cart
         */
        $cart = Yii::$app->cart;

        return $cart->getItem($fullPriceKey);
    }

    /**
     * @param string $fullPriceKey
     *
     * @return int
     */
    public static function getProductCountInCart(string $fullPriceKey) : int
    {
        /**
         * @var \devanych\cart\Cart $cart
         */
        $cart = Yii::$app->cart;
        $item = $cart->getItem($fullPriceKey);

        return $item ? $item->getQuantity() : 0;
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public static function getLoader() : string
    {
        return Html::tag('div', Html::img('/img/loader.gif', ['style' => 'display: none; width: 17px; vertical-align: middle;',]), ['class' => 'cart-loader', 'style' => 'display: inline-block;',]);
    }

    /**
     * @param FullPrice $fullPrice
     * @param bool      $isHidden
     *
     * @return string
     */
    public static function getCartButtons(FullPrice $fullPrice, bool $isHidden = false) : string
    {
        $html = Html::button(Html::tag('i', '', ['class' => 'fas fa-running',]), ['style' => $isHidden ? 'display:none;' : '', 'data' => ['id' => $fullPrice->{FullPrice::PRODUCT_KEY},],]).PHP_EOL;
        $html .= Html::button(Html::tag('i', '', ['class' => 'fas fa-cart-plus',]).self::getLoader(), ['style' => $isHidden ? 'display:none;' : '','class' => 'add-cart-button', 'data' => ['id' => $fullPrice->{FullPrice::PRODUCT_KEY},],]);

        return $html;
    }

    /**
     * @param Articles  $article
     * @param FullPrice $fullPrice
     * @param int       $count
     * @param bool      $isHidden
     *
     * @return string
     */
    public static function getCartPlusMinus(Articles $article, FullPrice $fullPrice, int $count = 1, bool $isHidden = true) : string
    {
        $html = Html::beginTag('div', ['class' => 'number', 'style' => $isHidden ? 'display:none;' : '', 'data' => ['id' => $fullPrice->{FullPrice::PRODUCT_KEY},]]);
        $html .= Html::tag('span', Html::tag('i', '', ['class' => 'fas fa-minus-circle',]), ['class' => 'minus',]);
        $html .= Html::textInput('count['.$article->id.']['.$fullPrice->{FullPrice::PRODUCT_KEY}.']', $count, ['size' => 99,]);
        $html .= Html::tag('span', Html::tag('i', '', ['class' => 'fas fa-plus-circle',]), ['class' => 'plus',]);
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * @param string $number
     *
     * @return bool
     */
    public static function isArticleInCart(string $number) : bool
    {
        return false;
    }

    /**
     * @return string
     */
    public static function renderEmptyCart() : string
    {
        return '
            <section class="empty-cart">
                <div class="empty-cart-banner">
                    <div class="empty-cart-banner__inner">
                        <div class="empty-cart-banner__picture">
                            <img src="/img/cart/empty-cart-banner-pic.svg" alt="">
                        </div>
                        <div class="empty-cart-banner__description-inner">
                            <div class="empty-cart-banner__title">
                                ваша корзина пока еще пуста
                            </div>
                            <div class="empty-cart-banner__text">
                                В нашем каталоге вы найдете все необходимое, на главной странице вы найдете все акции и спецпреложения, а так же поиск, чтобы найти нужный товар
                            </div>
                            <div class="empty-cart-banner__btns-wrapper">
                                <a href="/models" class="empty-cart-banner__primary-btn">перейти в каталог</a>
                                <a href="/" class="empty-cart-banner__secondary-btn">на главную</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ';
    }

    /**
     * @param CartSettings $model
     *
     * @return array
     */
    public static function getCartSettingTreeData($model = null) : array
    {
        $rootItem = ['name' => 'Общее', 'id' => 0, 'open' => true, 'url' => '/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/view?id='.self::CART_SETTINGS_GLOBAL_ID, Catalog::TREE_ITEM_CHILDREN => [],];

        $topSettings = CartSettings::find()->where(['parent_id' => 0, 'level' => CartSettings::LEVEL_1,])->orderBy(['sort' => SORT_ASC,])->indexBy('id')->asArray()->all();
        $otherSettings = CartSettings::find()->where(['>', 'parent_id', 0])->orderBy(['parent_id' => SORT_ASC, 'sort' => SORT_ASC,])->indexBy('id')->asArray()->all();

        foreach ($topSettings as $settingID => $setting) {
            $rootItem[Catalog::TREE_ITEM_CHILDREN][] = [
                'id' => $settingID,
                'parent_id' => 0,
                'name' => $setting['name'],
                'type' => $setting['type'],
                'is_active' => $setting['is_active'],
                'url' => '/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/view?id='.$settingID,
                'open' => $model && $model->parent_id === $settingID ? true : false,
            ];
        }

        foreach ($rootItem[Catalog::TREE_ITEM_CHILDREN] as $index => $setting) {
            $rootItem[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processCartSettings($setting, $otherSettings, $model);
        }

        return [$rootItem,];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public static function getCartTreeDataChildrens($id) : array
    {
        $result = CartSettings::find()->where(['parent_id' => $id])->orderBy(['sort' => SORT_ASC,])->indexBy('id')->asArray()->all();
        return $result;
    }

    /**
     * @param array $setting
     * @param array $otherSettings
     * @param CartSettings $model
     *
     * @return array
     */
    public static function _processCartSettings(array &$setting, array &$otherSettings, $model = null) : array
    {
        foreach ($otherSettings as $otherID => $other) {
            if ($setting['id'] === $other['parent_id']) {
                unset($otherSettings[$otherID]);

                $setting[Catalog::TREE_ITEM_CHILDREN][] = [
                    'id' => $otherID,
                    'parent_id' => $other['parent_id'],
                    'name' => $other['name'],
                    'description' => $other['description'],
                    'url' => '/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/view?id='.$otherID,
                    'font' => empty($other['is_active']) ? new JsExpression('{"color":"#8f8b8b", "font-style":"italic"}') : '',
                    'open' => $model && $model->parent_id === $otherID ? true : false,
                ];
            }
        }

        if (!empty($setting[Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($setting[Catalog::TREE_ITEM_CHILDREN] as $index => $other) {
                $setting[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processCartSettings($other, $otherSettings, $model);
            }
        }

        return $setting;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public static function getCartSettingTypeData(string $type) : array
    {
        $setting = [];
        $model = CartSettings::find()->where(['parent_id' => 0, 'level' => CartSettings::LEVEL_1, 'type' => $type,])->asArray()->one();
        if ($model) {
            $setting = $model;
            $otherSettings = CartSettings::find()->where(['>', 'parent_id', 0])->orderBy(['parent_id' => SORT_ASC, 'sort' => SORT_ASC,])->indexBy('id')->asArray()->all();

            self::_processCartSettingTypeData($setting, $otherSettings);
        }

        return $setting;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public static function getCartDataByType(string $type) : array
    {
        $setting = [];
        $model = CartSettings::find()->where(['parent_id' => 0, 'type' => $type,])->asArray()->one();
        if ($model) {
            $setting = $model;
            $otherSettings = CartSettings::find()->where(['>', 'parent_id', 0])->orderBy(['parent_id' => SORT_ASC, 'sort' => SORT_ASC,])->indexBy('id')->asArray()->all();

            self::_processCartSettingTypeData($setting, $otherSettings);
        }

        return $setting;
    }

    /**
     * @param array $setting
     * @param array $otherSettings
     *
     * @return array
     */
    public static function _processCartSettingTypeData(array &$setting, array &$otherSettings) : array
    {
        foreach ($otherSettings as $otherID => $other) {
            if ($setting['id'] === $other['parent_id']) {
                unset($otherSettings[$otherID]);

                $setting[Catalog::TREE_ITEM_CHILDREN][] = $other;
            }
        }

        if (!empty($setting[Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($setting[Catalog::TREE_ITEM_CHILDREN] as $index => $other) {
                $setting[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processCartSettingTypeData($other, $otherSettings);
            }
        }

        return $setting;
    }

    /**
     * @return string
     */
    public static function getCartSettingsImagesRootPath() : string
    {
        return \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.'files';
    }
}