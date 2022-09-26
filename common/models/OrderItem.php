<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property string $article_number
 * @property float $price
 * @property int $quantity
 * @property string $key
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Order $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
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
            [['order_id', 'article_number'], 'required'],
            [['order_id', 'quantity', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['article_number'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => PriceList::KEY_LENGTH,],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'article_number' => 'Article Number',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'key' => 'Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id',]);
    }
}
