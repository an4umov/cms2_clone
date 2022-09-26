<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "special_offers".
 *
 * @property int $id
 * @property string $article_number
 * @property string $product_code
 * @property string $title
 * @property string $product_name
 * @property string $offer_type
 * @property string $offer_name
 * @property int $created_at
 * @property int $updated_at
 */
class SpecialOffers extends \yii\db\ActiveRecord
{
    const OFFER_TYPE_FLAG = 'Флаг';
    const OFFER_TYPE_GROUPING = 'Группировка';

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
        return 'special_offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_number', 'product_code', 'offer_type', 'offer_name'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['article_number'], 'string', 'max' => 25],
            [['product_code'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 50],
            [['product_name'], 'string', 'max' => 100],
            [['offer_type'], 'string', 'max' => 15],
            [['offer_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_number' => 'Номенклатура.Артикул',
            'product_code' => 'Номенклатура.Код',
            'title' => 'Заголовок карточки',
            'product_name' => 'Текст карточки',
            'offer_type' => 'Тип спецпредложения',
            'offer_name' => 'Имя спецпредложения',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
