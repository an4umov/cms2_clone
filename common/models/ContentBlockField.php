<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "content_block_field".
 *
 * @property int $id
 * @property int $content_block_id
 * @property string $data JSON
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property ContentBlock $contentBlock
 */
class ContentBlockField extends \yii\db\ActiveRecord
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
        return 'content_block_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_block_id', 'data'], 'required'],
            [['content_block_id', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['content_block_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['data'], 'string'],
            [['content_block_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentBlock::class, 'targetAttribute' => ['content_block_id' => 'id',],],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_block_id' => 'Блок',
            'data' => 'Данные полей',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentBlock()
    {
        return $this->hasOne(ContentBlock::class, ['id' => 'content_block_id',]);
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @return string
     */
    public function getRawData() : string
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }
}
