<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reclama_status".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string $color
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 */
class ReclamaStatus extends \yii\db\ActiveRecord
{
    const TYPE_FLAG = 'Флаг';
    const TYPE_GROUPING = 'Группировка';

    const DEFAULT_COLOR = '#5a5653';
    const IN_STOCK = 'В наличии!';
    const IN_STOCK_COLOR = '#01b047';

    public static function getRandomColor() : string
    {
        $list = [self::DEFAULT_COLOR, '#01b047', '#F87818', '#0062bb', '#E93333',];
        $index = array_rand($list, 1);

        return $list[$index];
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
    public static function tableName()
    {
        return 'reclama_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['code'], 'string', 'max' => 9],
            [['name'], 'string', 'max' => 150],
            [['type'], 'string', 'max' => 15],
            [['color'], 'string', 'max' => 7],
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
            'name' => 'Наименование',
            'type' => 'Тип',
            'color' => 'Цвет',
            'description' => 'Описание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
