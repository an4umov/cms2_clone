<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "car_model".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $level
 * @property string $name
 * @property string $cirillic_name
 * @property string $alias
 * @property int $created_at
 * @property int $updated_at
 */
class CarModel extends \yii\db\ActiveRecord
{
    const LEVEL_BRAND = 'brand'; // 0 уровень
    const LEVEL_MODEL = 'model'; // 1 уровень
    const LEVEL_GENERATION = 'generation'; // 2 уровень
    const LEVEL_CONFIGURATION = 'configuration'; // 3 уровень
    const LEVEL_COMPLECTATION = 'complectation'; // 4 уровень

    const LEVELS = [self::LEVEL_BRAND, self::LEVEL_MODEL, self::LEVEL_GENERATION, self::LEVEL_CONFIGURATION, self::LEVEL_COMPLECTATION,];

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
        return 'car_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'name', 'cirillic_name', 'alias'], 'required'],
            [['id', 'parent_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['level'], 'string'],
            ['level', 'in', 'range' => self::LEVELS,],
            [['name', 'cirillic_name', 'alias'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'level' => 'Уровень',
            'name' => 'Название',
            'cirillic_name' => 'Название на русском',
            'alias' => 'Алиас для URL',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
