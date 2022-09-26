<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "custom_tag".
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ContentCustomTag[] $contentCustomTags
 */
class CustomTag extends \yii\db\ActiveRecord
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
        return 'custom_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required',],
            [['is_active'], 'boolean',],
            [['created_at', 'updated_at'], 'default', 'value' => null,],
            [['created_at', 'updated_at'], 'integer',],
            [['name'], 'string', 'max' => 50,],
            [['is_active',], 'default', 'value' => false,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'is_active' => 'Активен',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentCustomTags()
    {
        return $this->hasMany(ContentCustomTag::class, ['custom_tag_id' => 'id',]);
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }

    /**
     * @return int
     */
    public function getContentCustomTagsCount() : int
    {
        return $this->getContentCustomTags()->count();
    }
}
