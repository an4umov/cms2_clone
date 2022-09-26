<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_tree_content".
 *
 * @property int $id
 * @property int $content_id
 * @property int $content_tree_id
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Content $content
 * @property ContentTree $contentTree
 */
class ContentTreeContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_tree_content';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'content_tree_id'], 'required'],
            [['content_id', 'content_tree_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'content_tree_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id',]],
            [['content_tree_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentTree::class, 'targetAttribute' => ['content_tree_id' => 'id',]],
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
            'content_tree_id' => 'Папка контента',
            'sort' => 'Сортировка',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentTree()
    {
        return $this->hasOne(ContentTree::class, ['id' => 'content_tree_id',]);
    }
}
