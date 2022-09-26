<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "planfix_partner".
 *
 * @property int $id
 * @property int $planfix_id
 * @property int $one_c_id 1C
 * @property string $name
 * @property string $type
 * @property string $info
 * @property string $terms
 * @property string $last_change_info JSON
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PlanfixPartnerExt[] $planfixPartnerExts
 */
class PlanfixPartner extends \yii\db\ActiveRecord
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
        return 'planfix_partner';
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
            [['type', 'info', 'terms', 'last_change_info'], 'string'],
            [['name'], 'string', 'max' => 255],
            ['type', 'in', 'range' => self::TYPES,],
            [['planfix_id'], 'unique'],
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
            'name' => 'Название',
            'type' => 'Тип',
            'info' => 'Дополнительная информация',
            'terms' => 'Условия сотрудничества',
            'last_change_info' => 'Информация о последнем изменении',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanfixPartnerExts()
    {
        return $this->hasMany(PlanfixPartnerExt::class, ['planfix_id' => 'planfix_id']);
    }
}
