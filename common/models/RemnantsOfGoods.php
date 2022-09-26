<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "remnants_of_goods".
 *
 * @property int $id
 * @property string $product_code
 * @property string $article_number
 * @property string $product_name
 * @property int $quantity
 * @property int $created_at
 * @property int $updated_at
 */
class RemnantsOfGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'remnants_of_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_code'], 'required'],
            [['quantity', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['quantity', 'created_at', 'updated_at'], 'integer'],
            [['product_code'], 'string', 'max' => 30],
            [['article_number'], 'string', 'max' => 25],
            [['product_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_code' => 'Product Code',
            'article_number' => 'Article Number',
            'product_name' => 'Product Name',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
