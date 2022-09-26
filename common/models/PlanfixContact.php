<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "planfix_contact".
 *
 * @property int $id
 * @property int $planfix_id
 * @property int $one_c_id 1C
 * @property string $name
 * @property string $midName
 * @property string $lastName
 * @property string $type
 * @property string $customData JSON
 * @property string $phones JSON
 * @property string $email
 * @property string $address
 * @property string $site
 * @property string $skype
 * @property string $facebook
 * @property string $telegram
 * @property string $instagram
 * @property string $vk
 * @property string $icq
 * @property string $description
 * @property string $terms
 * @property string $last_change_info JSON
 * @property int $created_at
 * @property int $updated_at
 */
class PlanfixContact extends \yii\db\ActiveRecord
{
    const TYPE_CONTACT = 'contact';
    const TYPE_COMPANY = 'company';
    const TYPES = [self::TYPE_CONTACT, self::TYPE_COMPANY];

    private $_types;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planfix_contact';
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
            self::TYPE_CONTACT => 'Контакт',
            self::TYPE_COMPANY => 'Компания',
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
            [['planfix_id', 'name'], 'required'],
            [['planfix_id', 'one_c_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['planfix_id', 'one_c_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'description', 'terms', 'last_change_info', 'customData', 'phones',], 'string'],
            [['name', 'midName', 'lastName', 'email', 'address', 'site', 'skype', 'facebook', 'telegram', 'instagram', 'vk', 'icq'], 'string', 'max' => 255],
            [['planfix_id'], 'unique'],
            ['type', 'in', 'range' => self::TYPES,],
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
            'one_c_id' => '1С ID',
            'name' => 'Имя',
            'midName' => 'Отчество',
            'lastName' => 'Фамилия',
            'type' => 'Тип',
            'customData' => 'Пользовательские поля',
            'phones' => 'Список телефонов',
            'email' => 'Адрес электронной почты',
            'address' => 'Адрес',
            'site' => 'Веб-сайт',
            'skype' => 'Skype',
            'facebook' => 'Facebook',
            'telegram' => 'Telegram',
            'instagram' => 'Instagram',
            'vk' => 'Vk',
            'icq' => 'Icq',
            'description' => 'Дополнительная информация',
            'terms' => 'Условия сотрудничества',
            'last_change_info' => 'Информация о последнем изменении',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
