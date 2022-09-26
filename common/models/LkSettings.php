<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lk_settings".
 *
 * @property int $id
 * @property string $delivery_address
 * @property string $contractor_entity
 * @property string $contractor_person
 */
class LkSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lk_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_address', 'contractor_entity', 'contractor_person'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_address' => 'Адрес Домашний или Адрес Офиса',
            'contractor_entity' => 'Юридическое лицо или ИП',
            'contractor_person' => 'Частное лицо',
        ];
    }
}
