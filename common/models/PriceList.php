<?php

namespace common\models;

use common\components\helpers\CartHelper;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price_list".
 *
 * @property int    $id
 * @property string $code служебное поле, на сайте не отображается
 * @property string $cross_type
 * @property string $article_number
 * @property string $product_code
 * @property string $manufacturer
 * @property string $quality
 * @property string $price
 * @property string $availability
 * @property string $commentary
 * @property int    $multiplicity
 * @property string $key
 * @property int    $created_at
 * @property int    $updated_at
 *
 * @property Articles $article
 */
class PriceList extends \yii\db\ActiveRecord
{
    const CODE_PRICE_LR_RU = 'PRICE-LR-RU';

    const PRODUCT_KEY = 'key';
    const KEY_LENGTH = 10;

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
        return 'price_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'article_number', 'manufacturer'], 'required'],
            [['commentary',], 'string'],
            [['key'], 'string', 'max' => self::KEY_LENGTH,],
            [['multiplicity', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['multiplicity', 'created_at', 'updated_at'], 'integer'],
            [['code', 'cross_type', 'article_number', 'product_code', 'manufacturer', 'price'], 'string', 'max' => 64],
            [['quality', 'availability'], 'string', 'max' => 32],
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
            'code' => 'Код прайс листа',
            'cross_type' => 'Тип замены',
            'article_number' => 'Артикул товара',
            'product_code' => 'Код товара',
            'manufacturer' => 'Производитель',
            'quality' => 'Показатель качества',
            'price' => 'Цена товара',
            'availability' => 'Количество единиц товара в наличии',
            'commentary' => 'Комментарий для интернет-магазина',
            'multiplicity' => 'Кратность поставки товара',
            'key' => 'Key',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['number' => 'article_number',]);
    }

    /**
     * @return bool
     */
    public function isInCart() : bool
    {
        return !empty(CartHelper::getProduct($this->{self::PRODUCT_KEY}));
    }

    /**
     * @return int
     */
    public function getCountInCart() : int
    {
        return CartHelper::getProductCountInCart($this->{self::PRODUCT_KEY});
    }
}
