<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "shop_order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $article_id
 * @property string $code
 * @property string $article_number
 * @property string $product_code
 * @property string $manufacturer
 * @property double $price
 * @property string $key
 * @property int $quantity
 * @property string $name
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ShopOrder $order
 */
class ShopOrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_order_item';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'article_id', 'code', 'article_number', 'manufacturer', 'price', 'key', 'quantity', 'name'], 'required'],
            [['order_id', 'article_id', 'quantity', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order_id', 'article_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['code', 'article_number', 'product_code', 'manufacturer'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => 10],
            [['name', 'title'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopOrder::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Заказ',
            'article_id' => 'Article ID',
            'code' => 'Код',
            'article_number' => 'Номенклатура.Артикул',
            'product_code' => 'Номенклатура.Код',
            'manufacturer' => 'Производитель',
            'price' => 'Цена',
            'key' => 'Key',
            'quantity' => 'Количество',
            'name' => 'Название',
            'title' => 'Наименование',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(ShopOrder::class, ['id' => 'order_id',]);
    }
}
