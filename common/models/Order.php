<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $comment
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property OrderItem[] $orderItems
 * @property OrderLog[] $orderLogs
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 'pending'; // платеж создан и ожидает действий от пользователя. Платеж может перейти в succeeded, waiting_for_capture (при двухстадийной оплате) или canceled
    const STATUS_WAITING_FOR_CAPTURE = 'waiting_for_capture'; // платеж оплачен, деньги авторизованы и ожидают списания. Платеж может перейти в succeeded или canceled
    const STATUS_SUCCEEDED = 'succeeded'; // платеж успешно завершен
    const STATUS_CANCELED = 'canceled'; // платеж отменен

    const STATUSES = [self::STATUS_PENDING, self::STATUS_WAITING_FOR_CAPTURE, self::STATUS_SUCCEEDED, self::STATUS_CANCELED,];

    public $logMessage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @param string $status
     *
     * @return string
     */
    public function getStatusTitle(string $status) : string
    {
        return $this->getStatusTitles()[$status];
    }

    /**
     * @return array
     */
    public function getStatusTitles() : array
    {
        return [
            self::STATUS_PENDING => 'Платеж создан',
            self::STATUS_WAITING_FOR_CAPTURE => 'Ожидает списания',
            self::STATUS_SUCCEEDED => 'Платеж завершен',
            self::STATUS_CANCELED => 'Платеж отменен',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            ['status', 'in', 'range' => self::STATUSES,],
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
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getOrderItemsCount() : int
    {
        return $this->getOrderItems()->count();
    }

    /**
     * @return float
     */
    public function getOrderItemsCost() : float
    {
        $cost = 0;
        $items = $this->getOrderItems()->all();
        /**
         * @var OrderItem $item
         */
        foreach ($items as $item) {
            $cost += $item->price * $item->quantity;
        }

        return $cost;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLogs()
    {
        return $this->hasMany(OrderLog::class, ['order_id' => 'id',])->orderBy(['created_at' => SORT_ASC,]);
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $model = new OrderLog();
        $model->order_id = $this->id;
        $model->status = $this->status;

        if (!empty($this->logMessage)) {
            $model->message = $this->logMessage;
        }
        $model->save();

        parent::afterSave($insert, $changedAttributes);
    }
}
