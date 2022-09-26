<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "settings_main_shop_level".
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 */
class SettingsMainShopLevel extends \yii\db\ActiveRecord
{
    const TYPE_ONE = 'one';
    const TYPE_TWO = 'two';
    const TYPE_THREE = 'three';

    const TYPES = [self::TYPE_ONE, self::TYPE_TWO, self::TYPE_THREE,];

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
        return 'settings_main_shop_level';
    }

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        return [
            self::TYPE_ONE => 'Один блок',
            self::TYPE_TWO => 'Два блока',
            self::TYPE_THREE => 'Три блока',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            ['type', 'in', 'range' => self::TYPES,],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'type' => 'Тип блока верстки',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
