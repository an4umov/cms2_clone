<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property string $code
 * @property string $delivery
 * @property string $delivery_time
 * @property string $color
 * @property bool $stock
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code', 'delivery', 'delivery_time', 'color'], 'string'],
            [['stock'], 'bool'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'delivery' => 'Delivery name',
            'delivery_time' => 'Delivery time',
            'color' => 'Color',
            'stock' => 'Stock',
        ];
    }
}
