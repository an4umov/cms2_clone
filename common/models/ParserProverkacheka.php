<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_proverkacheka".
 *
 * @property int $id
 * @property int $number
 * @property string $inn
 * @property double $total
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 */
class ParserProverkacheka extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_proverkacheka';
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
    public function rules()
    {
        return [
            [['number', 'inn', 'total', 'type'], 'required'],
            [['number', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['number', 'created_at', 'updated_at'], 'integer'],
            [['total'], 'number'],
            [['inn', 'type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'inn' => 'ИНН',
            'total' => 'Итого, руб',
            'type' => 'Тип оплаты',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
