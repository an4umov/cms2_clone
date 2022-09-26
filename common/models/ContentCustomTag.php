<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_custom_tag".
 *
 * @property int $id
 * @property int $content_id
 * @property int $custom_tag_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Content $content
 * @property CustomTag $customTag
 */
class ContentCustomTag extends \yii\db\ActiveRecord
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
        return 'content_custom_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'custom_tag_id'], 'required'],
            [['content_id', 'custom_tag_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'custom_tag_id', 'created_at', 'updated_at'], 'integer'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id',],],
            [['custom_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomTag::class, 'targetAttribute' => ['custom_tag_id' => 'id',],],
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
            'custom_tag_id' => 'Тег',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::class, ['id' => 'content_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomTag()
    {
        return $this->hasOne(CustomTag::class, ['id' => 'custom_tag_id',]);
    }
}
