<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "question_sended".
 *
 * @property int $id
 * @property int $user_id
 * @property int $content_id
 * @property string $content_type
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property int $created_at
 * @property int $updated_at
 */
class QuestionSended extends \yii\db\ActiveRecord
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
        return 'question_sended';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'content_id', 'created_at', 'updated_at'], 'integer'],
            [['content_id', 'content_type', 'name', 'email', 'comment'], 'required'],
            [['comment'], 'string'],
            ['content_type', 'in', 'range' => Content::TYPES,],
            [['content_type'], 'string', 'max' => 256],
            [['name', 'email'], 'string', 'max' => 100],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'content_id' => 'Контент',
            'content_type' => 'Тип',
            'name' => 'Имя',
            'email' => 'Email',
            'comment' => 'Вопрос',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return Content|null
     */
    public function getContent() : ?Content
    {
        if (!empty($this->content_id) && !empty($this->content_type)) {
            return Content::findOne(['id' => $this->content_id, 'type' => $this->content_type,]);
        }

        return null;
    }
}
