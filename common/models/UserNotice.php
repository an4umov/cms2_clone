<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_notice".
 *
 * @property int $id
 * @property int $user_id
 * @property bool $is_order_received_email Получение Вашего заказа из Интернет-магазина, email
 * @property string $order_received_email
 * @property bool $is_order_received_sms Получение Вашего заказа из Интернет-магазина, sms
 * @property string $order_received_sms
 * @property bool $is_order_status_email Изменение статуса Вашего заказа, email
 * @property string $order_status_email
 * @property bool $is_order_status_sms Изменение статуса Вашего заказа, sms
 * @property string $order_status_sms
 * @property bool $is_balance_email Изменение баланса взаиморасчетов (поступления и списания денег), email
 * @property string $balance_email
 * @property bool $is_balance_sms Изменение баланса взаиморасчетов (поступления и списания денег), sms
 * @property string $balance_sms
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserNotice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notice';
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
            [['user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['is_order_received_email', 'is_order_received_sms', 'is_order_status_email', 'is_order_status_sms', 'is_balance_email', 'is_balance_sms',], 'boolean'],
            [['order_received_email', 'order_status_email', 'balance_email',], 'string', 'max' => 100],
            [['order_received_sms', 'order_status_sms', 'balance_sms'], 'string', 'max' => 25],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id',],],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'is_order_received_email' => 'E-mail',
            'order_received_email' => 'Order Received Email',
            'is_order_received_sms' => 'SMS на телефон',
            'order_received_sms' => 'Order Received Sms',
            'is_order_status_email' => 'E-mail',
            'order_status_email' => 'Order Status Email',
            'is_order_status_sms' => 'SMS на телефон',
            'order_status_sms' => 'Order Status Sms',
            'is_balance_email' => 'E-mail',
            'balance_email' => 'Balance Email',
            'is_balance_sms' => 'SMS на телефон',
            'balance_sms' => 'Balance Sms',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id',]);
    }

    public function initModel() : void
    {
        $this->is_order_received_email = false;
        $this->is_order_received_sms = false;
        $this->is_order_status_email = false;
        $this->is_order_status_sms = false;
        $this->is_balance_email = false;
        $this->is_balance_sms = false;
    }
}
