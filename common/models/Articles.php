<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $description
 * @property string $title
 * @property boolean $is_in_stock
 * @property boolean $is_in_epc
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Articles[] $articles
 * @property Images[] $images
 * @property FullPrice[] $fullPriceItems
 */
class Articles extends \yii\db\ActiveRecord
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
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['is_in_stock', 'is_in_epc',], 'boolean'],
            [['number'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 250],
            [['title'], 'string', 'max' => 100],
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
            'name' => 'Название',
            'description' => 'Описание',
            'title' => 'Заголовок',
            'is_in_stock' => 'В наличии',
            'is_in_epc' => 'В EPC',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::class, ['article' => 'number',])->orderBy(['order' => SORT_ASC,]);
    }

    /**
     * @return Articles[]
     */
    public function getArticles()
    {
        return self::findAll(['number' => $this->number,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFullPriceItems()
    {
        return $this->hasMany(FullPrice::class, ['article_number' => 'number',]);
    }

    /**
     * @return FullPrice|null
     */
    public function getFullPriceSale() : ?FullPrice
    {
        return $this->getFullPriceItems()->where(['<>', FullPrice::tableName().'.sale', ''])->orderBy([FullPrice::tableName().'.price' => SORT_ASC,])->one();
    }

    /**
     * @param     $number
     * @param int $orderStatus
     *
     * @return FullPrice[]
     */
    public function similarPrice($number, $orderStatus = FullPrice::ORDER_STATUS_AVAILABLE)
    {
        $query = FullPrice::find();
        $query->where(['article_number' => $number,]);

        switch ($orderStatus) {
            case FullPrice::ORDER_STATUS_AVAILABLE :
                $query->andWhere("delivery_time = 'На складе' OR delivery_time = 'Ожидается' OR `delivery_time` = ''");
                $query->andWhere("`price_list_code` = 'PRICE-LR-RU' OR `price_list_code` = 'ZAM-LR-RU' OR `price_list_code` = 'ANA-LR-RU' OR `price_list_code` = 'ORDERS-LR-RU' OR `price_list_code` = 'BRAK-LR-RU'");
                break;

            case FullPrice::ORDER_STATUS_PRE_ORDER :
                $query->andWhere("price_list_code <> 'PRICE-LR-RU' AND price_list_code <> 'ZAM-LR-RU' AND price_list_code <> 'ANA-LR-RU' AND `price_list_code` <> 'BRAK-LR-RU'");
                $query->andWhere("delivery_time <> 'Ожидается'");
                break;

            case FullPrice::ORDER_STATUS_AVAILABLE_AN_ZM :
                $query->andWhere("delivery_time = 'На складе' OR delivery_time = 'Ожидается' OR `delivery_time` = ''");
                $query->andWhere("`price_list_code` = 'ZAM-LR-RU' OR `price_list_code` = 'ANA-LR-RU'");
                break;
        }

        return $query->all();
    }
}
