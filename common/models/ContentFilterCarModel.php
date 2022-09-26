<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_filter_car_model".
 *
 * @property int $id
 * @property int $content_id
 * @property int $car_model_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Content $content
 */
class ContentFilterCarModel extends \yii\db\ActiveRecord
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
        return 'content_filter_car_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'car_model_id'], 'required'],
            [['content_id', 'car_model_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'car_model_id', 'created_at', 'updated_at'], 'integer'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Контент',
            'car_model_id' => 'Модель',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::class, ['id' => 'content_id',]);
    }
}
