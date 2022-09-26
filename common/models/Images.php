<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $url
 * @property int $order
 * @property string $article
 * @property int $created_at
 * @property int $updated_at
 */
class Images extends \yii\db\ActiveRecord
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
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'order', 'article'], 'required'],
            [['order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['url', 'article'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'order' => 'Order',
            'article' => 'Article',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string
     */
    public function getFullUrl() : string
    {
        return '/img/'.$this->url;
    }
}
