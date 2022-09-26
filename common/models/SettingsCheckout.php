<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "settings_checkout".
 *
 * @property int $id
 * @property int $reference_partner_id
 * @property bool $is_default Может быть только один
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ReferencePartner $referencePartner
 * @property SettingsCheckoutBuyer[] $settingsCheckoutBuyers
 * @property int $settingsCheckoutBuyersCount
 */
class SettingsCheckout extends \yii\db\ActiveRecord
{
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
        return 'settings_checkout';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_partner_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['reference_partner_id', 'created_at', 'updated_at'], 'integer'],
            [['is_default', 'is_active',], 'boolean'],
            [['is_default',], 'default', 'value' => false,],
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
            'reference_partner_id' => 'Партнер',
            'is_default' => 'По умолчанию',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferencePartner()
    {
        return $this->hasOne(ReferencePartner::class, ['id' => 'reference_partner_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingsCheckoutBuyers()
    {
        return $this->hasMany(SettingsCheckoutBuyer::class, ['settings_checkout_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getSettingsCheckoutBuyersCount() : int
    {
        return $this->getSettingsCheckoutBuyers()->count();
    }

    /**
     * @return string
     */
    public function getDefaultClass() : string
    {
        return $this->is_default ? 'success' : ($this->is_active ? 'default' : 'danger');
    }

    /**
     * @return array
     */
    public function getReferencePartnerOptions() : array
    {
        return ArrayHelper::map(ReferencePartner::find()->where(['is_active' => true, ])->orderBy(['name' => SORT_ASC,])->all(), 'id', 'name');
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $saved = parent::save($runValidation, $attributeNames);

        if ($this->is_default) {
            self::updateAll(['is_default' => false,], ['!=', 'id', $this->id,]);
        }

        return $saved;
    }

    public function delete()
    {
        $this->is_active = false;

        return $this->save(false);
    }
}
