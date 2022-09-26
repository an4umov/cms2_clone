<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "planfix_partner_ext".
 *
 * @property int $id
 * @property int $planfix_id
 * @property string $type
 * @property string $kind Вид контактной информации
 * @property string $value
 * @property string $last_change_info JSON
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PlanfixPartner $planfix
 */
class PlanfixPartnerExt extends \yii\db\ActiveRecord
{
    const TYPE_PHONE = 'phone';
    const TYPE_EMAIL = 'email';
    const TYPE_ADDRESS = 'address';
    const TYPE_SITE = 'site';
    const TYPE_SKYPE = 'skype';
    const TYPE_FACEBOOK = 'facebook';
    const TYPE_TELEGRAM = 'telegram';
    const TYPE_INSTAGRAM = 'instagram';
    const TYPE_VK = 'vk';
    const TYPE_ICQ = 'icq';

    const TYPES = [self::TYPE_PHONE, self::TYPE_EMAIL, self::TYPE_ADDRESS, self::TYPE_SITE, self::TYPE_SKYPE, self::TYPE_FACEBOOK, self::TYPE_TELEGRAM, self::TYPE_INSTAGRAM, self::TYPE_VK, self::TYPE_ICQ,];

    private $_types;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planfix_partner_ext';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_PHONE => 'Телефон',
            self::TYPE_EMAIL => 'Email',
            self::TYPE_ADDRESS => 'Адрес',
            self::TYPE_SITE => 'Сайт',
            self::TYPE_SKYPE => 'Скайп',
            self::TYPE_FACEBOOK => 'Facebook',
            self::TYPE_TELEGRAM => 'Телеграм',
            self::TYPE_INSTAGRAM => 'Инстаграм',
            self::TYPE_VK => 'ВК',
            self::TYPE_ICQ => 'ICQ',
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->_types[$type];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['planfix_id'], 'required'],
            [['planfix_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['planfix_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'last_change_info'], 'string'],
            [['kind', 'value'], 'string', 'max' => 255],
            ['type', 'in', 'range' => self::TYPES,],
            [['planfix_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanfixPartner::class, 'targetAttribute' => ['planfix_id' => 'planfix_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'planfix_id' => 'Planfix ID',
            'type' => 'Тип контактной информации',
            'kind' => 'Вид контактной информации',
            'value' => 'Значение',
            'last_change_info' => 'Информация о последнем изменении',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanfix()
    {
        return $this->hasOne(PlanfixPartner::class, ['planfix_id' => 'planfix_id']);
    }
}
