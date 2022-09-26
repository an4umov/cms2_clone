<?php

namespace common\models;

use common\components\helpers\ReferenceHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "settings_checkout_buyer".
 *
 * @property int $id
 * @property int $settings_checkout_id
 * @property int $reference_buyer_id
 * @property string $data JSON
 * @property boolean $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SettingsCheckout $settingsCheckout
 * @property ReferenceBuyer $referenceBuyer
 */
class SettingsCheckoutBuyer extends \yii\db\ActiveRecord
{
    public $dataDeliveryGroup;


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
        return 'settings_checkout_buyer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['settings_checkout_id', 'reference_buyer_id'], 'required'],
            [['settings_checkout_id', 'reference_buyer_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['settings_checkout_id', 'reference_buyer_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['is_active',], 'boolean'],
            [['is_active',], 'default', 'value' => true,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_checkout_id' => 'Настройка для партнера',
            'reference_buyer_id' => 'Покупатель',
            'data' => 'Данные',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return string
     */
    public function getActiveClass() : string
    {
        return $this->is_active ? 'default' : 'danger';
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }

    /**
     * @return int
     */
    public function getDeliveryGroupCount() : int
    {
        $data = $this->getData();
        if (!empty($data[ReferenceHelper::BUYER_DELIVERY_GROUP])) {
            return count($data[ReferenceHelper::BUYER_DELIVERY_GROUP]);
        }

        return 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingsCheckout()
    {
        return $this->hasOne(SettingsCheckout::class, ['id' => 'settings_checkout_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceBuyer()
    {
        return $this->hasOne(ReferenceBuyer::class, ['id' => 'reference_buyer_id',]);
    }

    /**
     * @return array
     */
    public function getReferenceBuyerOptions() : array
    {
        return $this->_getReferenceOptions(ReferenceBuyer::find());
    }

    /**
     * @return array
     */
    public function getReferenceDeliveryGroupOptions() : array
    {
        return $this->_getReferenceOptions(ReferenceDeliveryGroup::find());
    }

    /**
     * @return array
     */
    public function getReferenceDeliveryOptions() : array
    {
        return $this->_getReferenceOptions(ReferenceDelivery::find());
    }

    /**
     * @return array
     */
    public function getReferencePaymentGroupOptions() : array
    {
        return $this->_getReferenceOptions(ReferencePaymentGroup::find());
    }

    /**
     * @return array
     */
    public function getReferencePaymentOptions() : array
    {
        return $this->_getReferenceOptions(ReferencePayment::find());
    }

    /**
     * @param ActiveQuery $query
     *
     * @return array
     */
    private function _getReferenceOptions(ActiveQuery $query) : array
    {
        return ArrayHelper::map($query->where(['is_active' => true,])->orderBy(['name' => SORT_ASC,])->all(), 'id', 'name');
    }

    public function delete()
    {
        $this->is_active = false;

        return $this->save(false);
    }
}
