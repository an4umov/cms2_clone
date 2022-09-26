<?php

namespace common\models;

use common\components\helpers\CartHelper;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "full_price".
 *
 * @property int $id
 * @property string $price_list_code
 * @property string $partner
 * @property string $article_number
 * @property string $product_code
 * @property string $manufacturer
 * @property string $quality
 * @property string $product_name
 * @property string $price
 * @property string $sale
 * @property string $price_discount
 * @property string $price_opt
 * @property string $availability
 * @property string $delivery_time
 * @property string $delivery
 * @property string $commentary
 * @property string $multiplicity
 * @property string $commentary2
 * @property string $type_price_list
 * @property string $color
 * @property string $group_price_list
 * @property string $group_price_list_color
 * @property string $sale_color
 * @property string $key
 * @property int $created_at
 * @property int $updated_at
 *
 * @deprecated PriceList - новая версия
 */
class FullPrice extends \yii\db\ActiveRecord
{
    const ORDER_STATUS_AVAILABLE = 1;
    const ORDER_STATUS_PRE_ORDER = 2;
    const ORDER_STATUS_BOTH = 3;
    const ORDER_STATUS_AVAILABLE_AN_ZM = 4;

    const DELIVERY_PARTNER = 'у партнера';
    const DELIVERY_IN_STOCK = 'в наличии';
    const DELIVERY_ORDER = 'на заказ';
    const DELIVERY_STORAGE = 'на складе';

    const DELIVERY_TIME_ON_STOCK = 'На складе';
    const DELIVERY_TIME_MOSCOW_3_DAYS = 'Москва, 3 дня';
    const DELIVERY_TIME_EU_45_DAYS = '45 дней, EU';
    const DELIVERY_TIME_SPECIFIED = 'Уточняется';

    const GROUP_PRICE_LIST_DEFAULT = 'Магазин lr.ru';

    const PRODUCT_KEY = 'key';
    const KEY_LENGTH = 10;

    public $isReplace = false;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'full_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'price_discount', 'price_opt', 'multiplicity'], 'number'],
            [['commentary', 'commentary2', 'key',], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['price_list_code'], 'string', 'max' => 12],
            [['partner', 'quality'], 'string', 'max' => 100],
            [['article_number'], 'string', 'max' => 25],
            [['product_code'], 'string', 'max' => 30],
            [['delivery'], 'string', 'max' => 20],
            [['key'], 'string', 'max' => self::KEY_LENGTH,],
            [['manufacturer', 'delivery_time'], 'string', 'max' => 50],
            [['product_name', 'sale', 'group_price_list',], 'string', 'max' => 150],
            [['availability'], 'string', 'max' => 5],
            [['type_price_list',], 'string', 'max' => 9],
            [['color', 'group_price_list_color', 'sale_color',], 'string', 'max' => 7],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_list_code' => 'Price List Code',
            'partner' => 'Partner',
            'article_number' => 'Article Number',
            'product_code' => 'Product Code',
            'manufacturer' => 'Manufacturer',
            'quality' => 'Quality',
            'product_name' => 'Product Name',
            'price' => 'Price',
            'sale' => 'Sale',
            'price_discount' => 'Price Discount',
            'price_opt' => 'Price Opt',
            'availability' => 'Availability',
            'delivery_time' => 'Delivery Time',
            'delivery' => 'Delivery',
            'commentary' => 'Commentary',
            'multiplicity' => 'Multiplicity',
            'commentary2' => 'Commentary2',
            'type_price_list' => 'Type price list',
            'color' => 'Color',
            'group_price_list' => 'Group price list',
            'group_price_list_color' => 'Commentary2',
            'sale_color' => 'Sale color',
            'key' => 'Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return bool
     */
    public function isInCart() : bool
    {
        return !empty(CartHelper::getProduct($this->{FullPrice::PRODUCT_KEY}));
    }

    /**
     * @return int
     */
    public function getCountInCart() : int
    {
        return CartHelper::getProductCountInCart($this->{FullPrice::PRODUCT_KEY});
    }
}
