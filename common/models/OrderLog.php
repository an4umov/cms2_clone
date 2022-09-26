<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_log".
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property string $message
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Order $order
 */
class OrderLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_log';
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
            [['order_id'], 'required'],
            [['order_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order_id', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'string'],
            [['message'], 'string', 'max' => 255],
            ['status', 'in', 'range' => Order::STATUSES,],
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
            'status' => 'Status',
            'message' => 'Message',
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
