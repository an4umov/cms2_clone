<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "replacements".
 *
 * @property int $id
 * @property string $type_id
 * @property string $article_id
 * @property string $article_number
 * @property int $current_replacement
 * @property int $created_at
 * @property int $updated_at
 */
class Replacements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replacements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['current_replacement'], 'required'],
            [['current_replacement', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['current_replacement', 'created_at', 'updated_at'], 'integer'],
            [['type_id', 'article_number'], 'string', 'max' => 25],
            [['article_id'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'article_id' => 'Article ID',
            'article_number' => 'Article Number',
            'current_replacement' => 'Current Replacement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
