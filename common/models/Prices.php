<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "prices".
 *
 * @property int $id
 * @property string $product_code
 * @property string $article_number
 * @property string $product_name
 * @property string $price
 * @property int $sale
 * @property int $created_at
 * @property int $updated_at
 */
class Prices extends \yii\db\ActiveRecord
{
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
        return 'prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_code', 'article_number', 'product_name', 'price', 'sale'], 'required'],
            [['price'], 'number'],
            [['sale', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['sale', 'created_at', 'updated_at'], 'integer'],
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
            'price' => 'Price',
            'sale' => 'Sale',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
